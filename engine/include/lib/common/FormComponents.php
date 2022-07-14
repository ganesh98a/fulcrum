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

class FormComponents extends AbstractWebToolkit
{
	const __CHECKBOX_INPUT_PREFIX__ = 'ChkB';

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Generate html header for bootstrap dropdown menu with checkboxes.
	 *
	 * @param bool $includeSpanTag - True for original html form, false for ajax case.
	 * @param int $checkboxCount
	 * @return string - html
	 */
	public static function checkboxDropListHeader($checkboxCount=0, $includeParentOpeningSpanTag=true, $parentOpeningSpanTagElementId='') {

		// ajax call replacement htmlContents would not include span tag
		if ($includeParentOpeningSpanTag) {

			if (isset($parentOpeningSpanTagElementId) && !empty($parentOpeningSpanTagElementId)) {
				$parentOpeningSpanTagHtml =
'
			<span id="'.$parentOpeningSpanTagElementId.'" class="dropdown bootstrapDropdownHeader">
';
			} else {
				$parentOpeningSpanTagHtml =
'
			<span class="dropdown">
';
			}

		} else {
			$parentOpeningSpanTagHtml = '';
		}

		if ($checkboxCount == 0) {
			$checkboxCountHtml = '';
		} elseif ($checkboxCount > 0) {
			//$checkboxCountHtml = "[$checkboxCount]&nbsp;";
			$checkboxCountHtml = "[$checkboxCount]";
		}

		$checkboxDropListHeaderHtml = <<<END_HTML
$parentOpeningSpanTagHtml
				<button class="btn btn-default dropdown-toggle file-dropdown" type="button" data-toggle="dropdown">
					$checkboxCountHtml
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right dropdown-menu-cancel-collapse" role="menu">

END_HTML;

		return $checkboxDropListHeaderHtml;
	}

	/**
	 * Generic function to generate all checkbox for dropdown
	 *
	 * 1. function will take multiple css classes by order
	 *
	 * 2. input field name: we will use the more specific for it if given.
	 * e.g. if cls3 is given, we will use cls3
	 *
	 * @param string $checkboxValue
	 * @param string $dropdownItem
	 * @param string $cls1
	 * @param string $cls2
	 * @param string $cls3
	 * @return string
	 */
	public static function checkboxDropdownList($checkboxValue, $checkboxLabelText, $cssSelectorClassGrouping1 = '', $cssSelectorClassGrouping2 = '', $cssSelectorClassGrouping3 = '')
	{

		$checkboxInputPrefix = self::__CHECKBOX_INPUT_PREFIX__;
		//$checkboxName = $checkboxInputPrefix . $cssSelectorClassGrouping1 . '__' . $checkboxValue;

		$cssclass = $cssSelectorClassGrouping1;
		if (isset($cssSelectorClassGrouping2) && !empty($cssSelectorClassGrouping2)) {
			$cssclass .= " $cssSelectorClassGrouping2";
			//$checkboxName = $checkboxInputPrefix. $cssSelectorClassGrouping2 . '__' . $checkboxValue;
		}

		if (isset($cssSelectorClassGrouping3) && !empty($cssSelectorClassGrouping3)) {
			$cssclass .= " $cssSelectorClassGrouping3";
			//$checkboxName = $checkboxInputPrefix . $cssSelectorClassGrouping3 . '__' . $checkboxValue;
		}

		// Element with the name attribute for reference
		//					<input class="$cssclass" name="$checkboxName" type="checkbox" value="$checkboxValue">

		$html = <<<END_HTML
					<li>
						<label>
							<input class="$cssclass" type="checkbox" value="$checkboxValue">
							$checkboxLabelText
						</label>
					</li>

END_HTML;

		return $html;

	}

	public static function outputCheckboxDropdownArea($database, $arrSubcontractorBidDocumentsSubcontractorBid, $includeSpan = true) {
		$subcontractorBidHtml = FormComponents::checkboxDropListHeader($includeSpan);

				if (count($arrSubcontractorBidDocumentsSubcontractorBid) > 1) {
					$tmpHtml =
'
					<li>
						<label><input class="bidding-module-files-select-all-checkbox" name="" onclick="toggleAllChildBidDocuments(this);" type="checkbox">Select All</label>
					</li>
';
					$subcontractorBidHtml .= $tmpHtml;
				}


				foreach ($arrSubcontractorBidDocumentsSubcontractorBid as $subcontractor_bid_document_id => $subcontractorBidDocument) {
					$subcontractor_bid_document_sequence_number = $subcontractorBidDocument->subcontractor_bid_document_sequence_number;
					$subcontractor_bid_document_file_manager_file_id = $subcontractorBidDocument->subcontractor_bid_document_file_manager_file_id;
					$fileManagerFile = FileManagerFile::findById($database, $subcontractor_bid_document_file_manager_file_id);

					$virtual_file_name = '';
					$fileUrl = '';
					if ($fileManagerFile) {
						$fileUrl = $fileManagerFile->generateUrl();
						$virtual_file_name = $fileManagerFile->virtual_file_name;
					}
					if ($debugMode) {
						$virtual_file_name = '('.$subcontractor_bid_document_id.') '.$virtual_file_name;
					}
					$subcontractorBidHtml .= FormComponents::checkboxDropdownList(
						$subcontractor_bid_document_id,
						'<a tabindex="-1" target="_blank" href="'.$fileUrl.'">'.$virtual_file_name.'</a>',
						"bidding-module-files--subcontractor_bid_documents--subcontractor_bid_document_id",
						"bidding-module-files-subcontractor_bid_status_group_id-$subcontractor_bid_status_group_id--subcontractor_bid_documents--gc_budget_line_item_id--" . $gc_budget_line_item_id,
						"bidding-module-files--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--" . $subcontractor_bid_status_group_id
					);

				}
				$subcontractorBidHtml .= '</ul>';
				if($includeSpan) {
					$subcontractorBidHtml .= '</span>';
				}
				if (count($arrSubcontractorBidDocumentsSubcontractorBid) == 0) {
					$subcontractorBidHtml = '<span class="dropdown"></span>';
				}
				return $subcontractorBidHtml;
	}
}
