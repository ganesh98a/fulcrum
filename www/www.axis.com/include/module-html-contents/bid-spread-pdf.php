<?php

	// Convert html to pdf.

	echo
'<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="Bid Spread">
		<meta name="viewport" content="width=device-width">
		<meta http-equiv="imagetoolbar" content="false">
		<link rel="dns-prefetch" href="//ajax.googleapis.com">
		'.
		/*
		<link rel="stylesheet" href="'.$uri->http.'css/normalize.css">
		<link rel="stylesheet" href="'.$uri->http.'css/main.css">
		<link rel="stylesheet" href="'.$uri->http.'css/library-user_messages.css">
		<link rel="stylesheet" href="'.$uri->http.'css/styles.css">
		<link rel="stylesheet" href="'.$uri->http.'css/jquery-ui-1.10.0.custom.css">
		<link rel="stylesheet" href="'.$uri->http.'css/modules-purchasing-bid-spread.css">
		<link rel="stylesheet" href="'.$uri->http.'css/modules-permissions.css">
		*/
		'<style>
		html * {
			font-size: 70% !important;
		}
		</style>
	</head>
	<body>
';

	echo '
		<div id="purchasingBidSpreadContainer--'.$gc_budget_line_item_id.'" style="margin:20px;">
		<input id="project_id" type="hidden" value="'.$currentlySelectedProjectId.'">
		<input id="subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--'.$currentlySelectedProjectId.'" type="hidden" value="'.$gross_square_footage.'">
		<input id="subcontrator_bid_spread_reference_data-project-record--projects--net_rentable_square_footage--'.$currentlySelectedProjectId.'" type="hidden" value="'.$net_rentable_square_footage.'">
		<input id="subcontrator_bid_spread_reference_data-project-record--projects--unit_count--'.$currentlySelectedProjectId.'" type="hidden" value="'.$project_unit_count.'">
		<input id="gc_budget_line_item_id" type="hidden" value="'.$gc_budget_line_item_id.'">
		<input id="bid_spread_sequence_number" type="hidden" value="'.$bidSpread->bid_spread_sequence_number.'">
	';

	// @todo Figure Out Subtotals
	$tmpHtml = <<<TMP_HTML

		<div id="divSpreadButtons">
			<input id="btnImportBidItems" type="hidden" value="Import Bid Items" onclick="importBidItems('$gc_budget_line_item_id');">
		</div>
		<table id="spreadTable" cellspacing="0" border="1">
			<tbody>
			<tr class="notSortable">
				<th class="rightBorder" colspan="3" style="text-align: left;">$project_name</th>
TMP_HTML;
	echo $tmpHtml;

	$arrTotalsBySubcontractorBidId = array();
	$sort_order = 0;
	$arrPreferredSubcontractorBidIds = array();
	foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
		/* @var $subcontractorBid SubcontractorBid */

		$subcontractorContact = $subcontractorBid->getSubcontractorContact();
		/* @var $subcontractorContact Contact */

		$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
		/* @var $subcontractorBidStatus SubcontractorBidStatus */

		$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
		/* @var $subcontractorContactCompany ContactCompany */

		if ($subcontractorBidStatus->subcontractor_bid_status == 'Preferred Subcontractor Bid') {
			$arrPreferredSubcontractorBidIds[] = $subcontractor_bid_id;
		}

		$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'] = 0;
		$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'] = 0;

		if (isset($subcontractorBid->sort_order) && !empty($subcontractorBid->sort_order) && ($subcontractorBid->sort_order > 0)) {
			$sort_order = $subcontractorBid->sort_order;
		} else {
			$sort_order++;
		}

		$tmpHtml = <<<TMP_HTML

				<th class="rightBorder" colspan="4" nowrap>
					$subcontractorContactCompany->contact_company_name
				</th>
TMP_HTML;
		echo $tmpHtml;
	}

	$csvPreferredSubcontractorBidIds = join(',', $arrPreferredSubcontractorBidIds);

	$formatted_prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
	$formatted_forecasted_expenses = Format::formatCurrency($forecasted_expenses);
	echo '
			</tr>
			<tr class="notSortable">
				<td rowspan="2" class="rightBorder" style="vertical-align: top;">
					<table id="tblBudgetAmounts">
						<tr class="notSortable">
							<td colspan="2" class="budgetName"><span id="gc_budget_line_items--cost_code_divisions--division_number--'.$cost_code_division_id.'">'.$division_number.'</span>-<span id="gc_budget_line_items--cost_codes--cost_code--'.$cost_code_id.'">'.$cost_code.'</span> <span id="gc_budget_line_items--cost_codes--cost_code_description--'.$cost_code_id.'">'.$cost_code_description.'</span></td>
						</tr>
						<tr class="notSortable">
							<td>Prime Contract Scheduled Value:</td>
							<td align="right">'.$formatted_prime_contract_scheduled_value.'</td>
						</tr>
						<tr class="notSortable">
							<td>Forecasted Expenses:</td>
							<td align="right">'.$formatted_forecasted_expenses.'</td>
						</tr>

						<tr class="notSortable">
							<td colspan="2" style="text-align: right;">
								<!--<input id="btnLinkScheduledValues" type="button" value="Manage Scheduled Value Links" rel="tooltip" title="Click to manage linked scheduled values" onclick="loadLinkedGcBudgetLineItems(\''.$gc_budget_line_item_id.'\');">-->
							</td>
						</tr>
	';
						$linkedPrimeContractScheduledValuesTotal = $prime_contract_scheduled_value;
						$linkedForecastedExpensesTotal = $forecasted_expenses;

						$loadLinkedGcBudgetLineItemsOptions = new Input();
						$loadLinkedGcBudgetLineItemsOptions->forceLoadFlag = true;
						$arrLinkedGcBudgetLineItems = GcBudgetLineItemRelationship::loadLinkedGcBudgetLineItems($database, $gc_budget_line_item_id, $loadLinkedGcBudgetLineItemsOptions);
						//$arrLinkedBudgetItems = getLinkedScheduledValues($database, $gc_budget_line_item_id);
						if (count($arrLinkedGcBudgetLineItems) > 0) {
							$showLinkedScheduledValuesStyle = '';
							/*
							if ($showLinkedScheduledValues == 0) {
								$showLinkedScheduledValuesStyle = ' style="display:none;"';
							}
							echo '
								<tr class="notSortable">
									<td colspan="2" class="linkedHeader evenRow" onclick="toggleDisplayLinkedCostCodes(\''.$bid_spread_id.'\');">Linked Scheduled Values <a class="showHideLink" href="#">(show/hide)</a></td>
								</tr>
							';
							*/
							foreach ($arrLinkedGcBudgetLineItems AS $linked_gc_budget_line_item_id => $linkedGcBudgetLineItem) {
								/* @var $linkedGcBudgetLineItem GcBudgetLineItem */

								$linkedCostCode = $linkedGcBudgetLineItem->getCostCode();
								/* @var $linkedCostCode CostCode */

								//$linkedCostCodeDivision = $linkedGcBudgetLineItem->getCostCodeDivision();
								$linkedCostCodeDivision = $linkedCostCode->getCostCodeDivision();
								/* @var $linkedCostCodeDivision CostCodeDivision */

								$formattedLinkedCostCode = $linkedCostCode->getFormattedCostCode($database);

								$linked_prime_contract_scheduled_value = $linkedGcBudgetLineItem->prime_contract_scheduled_value;
								$linked_forecasted_expenses = $linkedGcBudgetLineItem->forecasted_expenses;
								$formatted_linked_prime_contract_scheduled_value = Format::formatCurrency($linked_prime_contract_scheduled_value);
								$formatted_linked_forecasted_expenses = Format::formatCurrency($linked_forecasted_expenses);

								$linkedPrimeContractScheduledValuesTotal = $linkedPrimeContractScheduledValuesTotal + $linked_prime_contract_scheduled_value;
								$linkedForecastedExpensesTotal = $linkedForecastedExpensesTotal + $linked_forecasted_expenses;

								echo '
									<tr class="notSortable linkedRow"'.$showLinkedScheduledValuesStyle.'>
										<td colspan="2" class="budgetName">'.$formattedLinkedCostCode.'</td>
									</tr>
									<tr class="notSortable linkedRow"'.$showLinkedScheduledValuesStyle.'>
										<td>Prime Contract Scheduled Value:</td>
										<td align="right">'.$formatted_linked_prime_contract_scheduled_value.'</td>
									</tr>
									<tr class="notSortable linkedRow"'.$showLinkedScheduledValuesStyle.'>
										<td>Forecasted Expenses:</td>
										<td align="right">'.$formatted_linked_forecasted_expenses.'</td>
									</tr>
								';
							}

							$formattedLinkedPrimeContractScheduledValuesTotal = Format::formatCurrency($linkedPrimeContractScheduledValuesTotal);
							$formattedLinkedForecastedExpensesTotal = Format::formatCurrency($linkedForecastedExpensesTotal);

							echo '
								<tr class="notSortable linkedRow"'.$showLinkedScheduledValuesStyle.'>
									<td colspan="2" class="linkedHeader" style="font-weight: bold">Totals</td>
								</tr>
								<tr class="notSortable">
									<td>Prime Contract Scheduled Value:</td>
									<td align="right">'.$formattedLinkedPrimeContractScheduledValuesTotal.'</td>
								</tr>
								<tr class="notSortable">
									<td>Forecasted Expenses:</td>
									<td align="right">'.$formattedLinkedForecastedExpensesTotal.'</td>
								</tr>
								';

						}
	echo '
					</table>
					<input id="linkedScheduledTotal" type="hidden" value="'.$linkedPrimeContractScheduledValuesTotal.'">
				</td>
	';

	foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
		/* @var $subcontractorBid SubcontractorBid */

		$subcontractorContact = $subcontractorBid->getSubcontractorContact();
		/* @var $subcontractorContact Contact */

		$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
		/* @var $subcontractorBidStatus SubcontractorBidStatus */

		$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
		/* @var $subcontractorContactCompany ContactCompany */

		$contactFullName = $subcontractorContact->getContactFullName();

		echo '
				<td colspan="4" class="rightBorder bidderHeaderDetails" style="text-align: center">'.$contactFullName.'</td>
		';
	}
	echo '
			</tr>
			<tr class="notSortable">
	';

	foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
		/* @var $subcontractorBid SubcontractorBid */

		$subcontractorContact = $subcontractorBid->getSubcontractorContact();
		/* @var $subcontractorContact Contact */

		if ($subcontractorContact) {
			$contact_email = $subcontractorContact->email;
		} else {
			$contact_email = '';
		}

		//$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
		/* @var $subcontractorBidStatus SubcontractorBidStatus */

		//$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
		/* @var $subcontractorContactCompany ContactCompany */

		$arrPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $subcontractorContact->contact_id);

		echo '
				<td colspan="4" class="rightBorder bidderHeaderDetails" style="text-align: center; padding:0; vertical-align:top;">
					<table border="0" style="margin: 0 auto;">
		';

		foreach ($arrPhoneNumbers AS $contactPhoneNumber) {
			echo '
						<tr class="notSortable">
							<td>'.$contactPhoneNumber->phone_number_type.'</td>
							<td>'.$contactPhoneNumber->getFormattedNumber().'</td>
						</tr>
			';
		}

		echo '
						<tr class="notSortable">
							<td>Email</td>
							<td><a href="mailto:'.$contact_email.'">'.$contact_email.'</a></td>
						</tr>
					</table>
				</td>
		';
	}

	echo '
			</tr>
			<tr class="notSortable">
				<th class="rightBorder permissionTableMainHeader" style="text-align: left;">Bid Spread Items</th>
	';
	foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
		echo '
				<th class="permissionTableMainHeader">Qty</th>
				<th class="permissionTableMainHeader">Unit</th>
				<th class="permissionTableMainHeader">Unit Price</th>
				<th class="permissionTableMainHeader">Total</th>
				<!--<th class="rightBorder permissionTableMainHeader" rel="tooltip" title="Excluded This Item From Total">&nbsp;</th>-->
		';
	}
	echo '
			</tr>
	';

	$tabIndex = 0;
	$subtotal = 0;
	$total = 0;
	// Important to iterate over bid_items as there may be no associations to subcontractor_bids via bid_items_to_subcontractor_bids
	foreach ($arrBidItemsByGcBudgetLineItemId AS $bid_item_id => $bidItem) {
		/* @var $bidItem BidItem */

		$bid_item = $bidItem->bid_item;
		$subtotalRow = '';
		$subtotalInput = '';
		if (stristr($bid_item, 'subtotal') || stristr($bid_item, 'sub total')) {
			$subtotalRow = ' subtotal-row';
			$subtotalInput = 'subtotal-input';
		}

		echo '
			<tr id="bidItemRow-'.$bid_item_id.'" class="rowBidItems'.$subtotalRow.'">
				<!--<td class="spread-td tdSortBars" rel="tooltip" title="Drag bars to change sort order"><img src="/images/sortbars.png"></td>-->
				<td class="spread-td">
					<span class="bid_item">'.$bid_item.'</span>
				</td>
				<!--<td class="spread-td rightBorder"></td>-->
		';
		if (isset($arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$bid_item_id])) {
			$arrBidItemsToSubcontractorBidsByBidItemId = $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$bid_item_id];
		} else {
			$arrBidItemsToSubcontractorBidsByBidItemId = array();
		}
		foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
			$item_quantity = '';
			$unit = '';
			$unit_price = '';
			$unitTotal = '';
			$exclude_bid_item_flag = 'N';
			if (isset($arrBidItemsToSubcontractorBidsByBidItemId[$subcontractor_bid_id])) {
				$bidItemToSubcontractorBid = $arrBidItemsToSubcontractorBidsByBidItemId[$subcontractor_bid_id];
				/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */

				$item_quantity = $bidItemToSubcontractorBid->item_quantity;
				$unit = $bidItemToSubcontractorBid->unit;
				$unit_price = $bidItemToSubcontractorBid->unit_price;
				$unitTotal = $item_quantity * $unit_price;
				$exclude_bid_item_flag = $bidItemToSubcontractorBid->exclude_bid_item_flag;
			}

			if ($exclude_bid_item_flag == 'Y') {
				$excludeBidItemFlagChecked = 'checked';
				$exclude = 'exclude';
			} else {
				$excludeBidItemFlagChecked = '';
				$exclude = '';

				$subtotal = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'];
				$subtotal = $subtotal + $unitTotal;
				$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'] = $subtotal;

				$total = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
				$total = $total + $unitTotal;
				$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'] = $total;
			}

			if ($subtotalRow != '') {
				$unitTotal = $subtotal;
				$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'] = 0;
			}

			if ($item_quantity < 0) {
				$itemQuantityColorClass = ' red';
			} else {
				$itemQuantityColorClass = '';
			}
			if ($item_quantity == 0) {
				$item_quantity = '';
			}

			if ($unit_price < 0) {
				$unitPriceColorClass = ' red';
			} else {
				$unitPriceColorClass = '';
			}
			if ($unit_price != '' && $unit_price != 0) {
				$unit_price = Format::formatCurrency($unit_price);
			} else {
				$unit_price = '';
			}

			if ($unitTotal < 0) {
				$unitTotalColorClass = ' red';
			} else {
				$unitTotalColorClass = '';
			}
			if ($unitTotal != '' && $unitTotal != 0) {
				$unitTotal = Format::formatCurrency($unitTotal);
			} else {
				$unitTotal = '';
			}

			$tmpHtml = <<<TMP_HTML

				<td class="spread-td">
					<span class="input-unit-qty number-only{$itemQuantityColorClass}">$item_quantity</span>
				</td>
				<td class="spread-td">
					<span class="input-unit">$unit</span>
				</td>
				<td class="spread-td">
					<span class="input-unit-price number-only{$unitPriceColorClass}">$unit_price</span>
				</td>
				<td class="spread-td">
					<span class="input-unit-total$subtotalInput{$unitTotalColorClass}">$unitTotal</span>
				</td>
TMP_HTML;
			echo $tmpHtml;
		}
		echo '
			</tr>
		';
	}

	echo '
			<tr class="notSortable">
				<th class="rightBorder" style="text-align: left;">Subcontractor Bid Total</th>
	';
	foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
		/* @var $subcontractorBid SubcontractorBid */

		$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
		/* @var $subcontractorBidStatus SubcontractorBidStatus */

		//$subcontractorBid = $arrSubcontractorBidsByGcBudgetLineItemId[$subcontractor_bid_id];
		$derivedSubcontractorBidTotal = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
		$formattedDerivedSubcontractorBidTotal = Format::formatCurrency($derivedSubcontractorBidTotal);
		$checkboxPreferredSubElementId = '';

		if ($subcontractorBidStatus->subcontractor_bid_status == 'Preferred Subcontractor Bid') {
			$checked = ' checked';
			$checkboxClass = '';
			$preferredSubCheckboxClass = ' preferredSub';
			$preferredSubTdClass = ' preferredSub';
			$openSubcontractsDialogLinkStyle =  '';
			$preferredSubcontractorText = 'Preferred Subcontractor';
		} else {
			$checked = '';
			$checkboxClass = '';
			$preferredSubTdClass = '';
			$openSubcontractsDialogLinkStyle =  ' style="display:none;"';
			$preferredSubcontractorText = '';
		}

		$tmpHtml = <<<TMP_HTML

				<th id="td1_preferred-$subcontractor_bid_id" class="$preferredSubTdClass" colspan="3" style="text-align: right;">
					$preferredSubcontractorText
					<!--<input id="preferred-$subcontractor_bid_id" type="checkbox" class="input-preferred-sub$checkboxClass" onclick="updatePreferredSubcontractor('$gc_budget_line_item_id', '$subcontractor_bid_id');"$checked>-->
					<!--<a id="preferred-sub-link-$subcontractor_bid_id" class="preferred-sub-link"$openSubcontractsDialogLinkStyle href="javascript:openSubcontractsDialog('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$subcontractor_bid_id');">Subcontract</a>-->
					<!--input type="button" onclick="openSubcontractsDialog('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id');" value="Subcontract"-->
				</th>
				<th id="td2_preferred-$subcontractor_bid_id" class="$preferredSubTdClass">
					<span class="input-unit-total bidder-total">$formattedDerivedSubcontractorBidTotal</span>
				</th>
				<!--<th id="td3_preferred-$subcontractor_bid_id" class="rightBorder$preferredSubTdClass">&nbsp;</th>-->
TMP_HTML;
		echo $tmpHtml;
	}
	echo '
			</tr>
	';

	echo '
			<tr class="notSortable">
				<th class="rightBorder" style="text-align: left;">Variance</th>
	';
	foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
		$subcontractorBidTotal = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
		$variance = $linkedPrimeContractScheduledValuesTotal - $subcontractorBidTotal;
		$formattedVariance = Format::formatCurrency($variance);
		$varianceStyle = '';
		if ($variance < 0) {
			$varianceStyle = ' red';
		}
		echo '
				<th colspan="3" style="text-align: right;">&nbsp;</th>
				<th>
					<span class="input-unit-total bidder-total'.$varianceStyle.'">'.$formattedVariance.'</span>
				</th>
				<!--<th class="rightBorder">&nbsp;</th>-->
		';
	}
	echo '
			</tr>
	';

	$formatted_gross_square_footage = number_format($gross_square_footage, 0);
	echo '
			<tr class="notSortable">
				<th class="rightBorder" style="text-align: left;" nowrap>Cost Per Gross Sq. Ft ('.$formatted_gross_square_footage.')</th>
	';
	foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
		$totalPerSquareFoot = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
		if (isset($gross_square_footage) && !empty($gross_square_footage)) {
			$totalPerSquareFoot = $totalPerSquareFoot / $gross_square_footage;
			$totalPerSquareFoot = Format::formatCurrency($totalPerSquareFoot);
		} else {
			$totalPerSquareFoot = '';
		}
		echo '
				<td colspan="4" align="right"><input id="subcontractorBidTotalCostPerGrossSquareFoot--'.$subcontractor_bid_id.'" type="text" class="input-unit-total bidder-total" value="'.$totalPerSquareFoot.'" readonly></td>
				<!--<td class="rightBorder">&nbsp;</td>-->
		';
	}
	echo '
			</tr>
	';

	$formatted_project_unit_count = number_format($project_unit_count, 0);
	if (($project_unit_count == 0) || ($project_unit_count > 1)) {
		$unitsLabel = ' Units';
	} elseif (($project_unit_count == 1)) {
		$unitsLabel = ' Unit';
	} else {
		$unitsLabel = '';
	}
	echo '
			<tr class="notSortable">
				<th class="rightBorder" style="text-align: left;" nowrap>Cost Per Unit ('.$formatted_project_unit_count.$unitsLabel.')</th>
	';
	foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
		$totalPerUnit = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
		if (isset($project_unit_count) && !empty($project_unit_count)) {
			$totalPerUnit = $totalPerUnit / $project_unit_count;
			$formattedTotalPerPerUnit = Format::formatCurrency($totalPerUnit);
		} else {
			$totalPerUnit = '';
		}
		echo '
				<td colspan="4" align="right"><input id="subcontractorBidTotalCostPerUnit--'.$subcontractor_bid_id.'" type="text" class="input-unit-total bidder-total" value="'.$formattedTotalPerPerUnit.'" readonly></td>
				<!--<td class="rightBorder">&nbsp;</td>-->
		';
	}
	echo '
			</tr>
	';

	echo '
		</table>
		</div>
		<div id="messageDiv" class="userMessage"></div>
		<div id="divModalWindow" rel="tooltip" title="">&nbsp;</div>
		</body>
		</html>
	';
