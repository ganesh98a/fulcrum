<?php

// FUNCTIONS
function createBidListDropDownForUserCompany($database, $user_company_id, $selected_bid_list_id=0) {
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$content = "\n";
	$content .= '<select id="ddlBidList" name="ddlBidList" onchange="ddlBidListChanged();">'."\n";
	$arrBidLists = BidList::loadBidListsByUserCompanyId($database, $user_company_id);

	if (empty($arrBidLists)) {
		$content .= '<option value="0" selected>No Bid Lists Exist</option>'."\n";
	} else {
		if ($selected_bid_list_id == 0) {
			$content .= '<option value="0" selected>Please Select A Bid List To Edit</option>'."\n";
		} else {
			$content .= '<option value="0">Please Select A Bid List To Edit</option>'."\n";
		}

		foreach ($arrBidLists as $bid_list_id => $bidList) {
			$bid_list_name = $bidList->bid_list_name;

			if ($bid_list_id == $selected_bid_list_id) {
				$content .= '<option value="'.$bid_list_id.'" selected>'.$bid_list_name.'</option>'."\n";
			} else {
				$content .= '<option value="'.$bid_list_id.'">'.$bid_list_name.'</option>'."\n";
			}
		}
	}

	$content .= '</select><input id="refreshBidListDetails" onclick="ddlBidListChanged();" style="display:none;" type="button" value="Refresh Bid List Details">'."\n";

	return $content;

	/*
	//$selected_bid_list_id = 0; // THIS COULD GET STORED IN THE SESSION
	//$selected_bid_list_name = '&nbsp;';
	global $selected_bid_list_id, $selected_bid_list_name;

	$query =
"
SELECT *
FROM `bid_lists`
WHERE `user_company_id` = ?
ORDER BY `bid_list_name` ASC
";
	$arrValues = array($user_company_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$noItems = true;
	while ($row = $db->fetch()) {
		$bid_list_id = $row['id'];
		$bid_list_name = $row['bid_list_name'];

		if ($noItems) {
			$content .= '
				<select id="ddlBidList" name="ddlBidList" onchange="ddlBidListChanged();">
				<option value="">Please Select A Bid List To Edit</option>
			';
			$selected_bid_list_id = $bid_list_id;
			$selected_bid_list_name = $bid_list_name;
		}

		$noItems = false;
		if ($bid_list_id == $bid_list_id_to_set_selected) {
			$selected_bid_list_id = $bid_list_id;
			$selected_bid_list_name = $bid_list_name;
			$content .= '<option value="'.$bid_list_id.'" selected>'.$bid_list_name.'</option>';
		} else {
			$content .= '<option value="'.$bid_list_id.'">'.$bid_list_name.'</option>';
		}
	}
	$db->free_result();

	if ($noItems == false) {
		$content .= '
			</select>
		';
	} else {
		$content .= '
			<select id="ddlBidList" name="ddlBidList" onchange="ddlBidListChanged();">
				<option value="0">No Bid Lists Exist</option>
			</select>
		';
	}

	return $content;
	*/
}

function buildContactListForBidList($database, $user_company_id, $bid_list_id, $userCanManageBidListCompanies) {
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$content = "";

	$query = "
SELECT
	c.*,
	cc.`company`,
	ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`,
	codes.`id` as 'cost_code_id', codes.`cost_code`, codes.`cost_code_description`,
	c.`id` AS 'contact_id',
	cc.`id` as 'contact_company_id'
FROM `bid_lists_to_contacts` bl2c
	INNER JOIN `contacts` c ON bl2c.`contact_id` = c.`id`
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	LEFT OUTER JOIN `subcontractor_trades` st ON c.`contact_company_id` = st.`contact_company_id`
	LEFT OUTER JOIN `cost_codes` codes ON st.`cost_code_id` = codes.`id`
	LEFT OUTER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE bl2c.`bid_list_id` = ?
ORDER BY division_number, cost_code, company, first_name, last_name
	";
	$arrValues = array($bid_list_id);
	//$arrValues = array($bid_list_id, $user_company_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$content = '<table cellspacing="0" cellpadding="5" border="1" style="border-collapse:collapse;">';

	$noItems = true;
	$currentCostCodeHeadline = '';
	$currentDivisionNumber = '-1';
	$first = true;
	while ($row = $db->fetch()) {
		//$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
		$noItems = false;

		$company_name = $row['company'];
		$contact_company_id = $row['contact_company_id'];
		// Debug
		//$contact_company_id = null;
		$division_number = $row['division_number'];
		$division_code_heading = $row['division_code_heading'];
		$division = $row['division'];
		$cost_code = $row['cost_code'];
		$cost_code_description = $row['cost_code_description'];

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

		$contactFullName = $contact->getContactFullName();

		if ($cost_code == '' && $cost_code_description == '') {
			$costCodeHeadline = 'Companies Without Specified Trades';
			$divisionHeadline = 'Uncategorized Subcontractors';
		} else {
			$costCodeHeadline = $division_number.'-'.$cost_code . ' ' . $cost_code_description;
			$divisionHeadline = $division_number.' '.$division.' ('.$division_number.'-'.$division_code_heading.')';
		}

		if ($currentDivisionNumber <> $division_number) {
			$currentDivisionNumber = $division_number;
			//#95B42E
			if ($first) {
				$first = false;
			} else {
				$content .= '<tr><th colspan="3" style="border-left:1px white !important; border-right:0px !important;">&nbsp;</th></tr>';
			}
			$content .= '<tr style="background:#3b90ce;"><th colspan="3">'.$divisionHeadline.'</th></tr>';
		}

		if ($currentCostCodeHeadline != $costCodeHeadline) {
			$content .= '<tr style="background:grey;"><td colspan="3">'.$costCodeHeadline.'</td></tr>';
		}

		$content .= '
			<tr id="'.$contact_id.'">
		';

		if ($userCanManageBidListCompanies) {
			$content .= "<td><a href=\"javascript:removeContactFromBidList('$bid_list_id', '$contact_id', '$contactFullName');\">X</a></td>";
		}

		$content .= "
				<td>$contactFullName</td>
				<td><a href=\"javascript:bidListCompanySelected('$contact_company_id', '$company_name', '$userCanManageBidListCompanies');\">$company_name</a></td>
			</tr>
		";

		$currentCostCodeHeadline = $costCodeHeadline;
	}
	$db->free_result();

	if ($noItems) {
		$content = 'No Contacts Have Been Added To This Bid List';
	} else {
		$content .= '
			</table>
		';
	}

	return $content;
}
