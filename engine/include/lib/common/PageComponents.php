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

class PageComponents extends AbstractWebToolkit
{
	/**
	 * Constructor.
	 *
	 * @return void
	 *
	 */
	public function __construct()
	{
	}

	public static function dropDownList($name, $arrOptions, $selectedOption='', $tabIndex='', $js='', $includeNameAttribute=true,$prependedOption='')
	{
		if ($tabIndex) {
			 $tabIndex = 'tabindex="'.$tabIndex.'"';
		}

		if ($includeNameAttribute) {
			$dropDownList = '<select id="'.$name.'" name="'.$name.'" '.$tabIndex.' '.$js.'>';
		} else {
			$dropDownList = '<select id="'.$name.'" '.$tabIndex.' '.$js.'>';
		}
		if($prependedOption)
		{
			$dropDownList .= $prependedOption;
		}

		foreach ($arrOptions as $k => $v) {
			if ($k == $selectedOption) {
				$selected = ' selected';
			} else {
				$selected = '';
			}
			$htmlK = htmlentities($k, ENT_QUOTES, 'UTF-8');
			$htmlV = htmlentities($v, ENT_QUOTES, 'UTF-8');
			$dropDownList .= '<option '.$selected.' value="'.$htmlK.'">'.$htmlV.'</option>';
		}

		$dropDownList .= '</select>';

		return $dropDownList;
	}

	public static function dropDownListFromObjects($name, $arrObjects, $keyProperty=null, $keyMethod=null, $valueProperty=null, $valueMethod=null, $selectedOption='', $tabIndex='', $js='', $prependedOption='')
	{
		if ($tabIndex) {

			$tabIndexHtml = <<<END_TAB_INDEX
tabindex="$tabIndex"
END_TAB_INDEX;

		} else {

			$tabIndexHtml = '';

		}

		$dropDownList = <<<END_DROP_DOWN_LIST
<select id="$name" name="$name" $tabIndexHtml $js>$prependedOption
END_DROP_DOWN_LIST;

		foreach ($arrObjects as $object) {

			if (isset($keyProperty)) {
				$k = $object->$keyProperty;
			} else {
				$k = call_user_func(array($object, $keyMethod));
			}

			if (isset($valueProperty)) {
				$v = $object->$valueProperty;
			} else {
				$v = call_user_func(array($object, $valueMethod));
			}

			if ($k == $selectedOption) {
				$selected = ' selected';
			} else {
				$selected = '';
			}

			$htmlK = htmlentities($k, ENT_QUOTES, 'UTF-8');
			$htmlV = htmlentities($v, ENT_QUOTES, 'UTF-8');

			$dropDownList .= <<<END_DROP_DOWN_LIST

<option$selected value="$htmlK">$htmlV</option>
END_DROP_DOWN_LIST;

		}

		$dropDownList .=
'
</select>';

		return $dropDownList;
	}

	public static $paginatorStack = array();

	public static function Paginate($uri, $total, $paginationType='general')
	{
		if ($paginationType == 'product') {
			$baseUrl = $uri->productUrlBase;
			$tab = $uri->productActiveTab;
			$offset = $uri->productOffset;
			$limit = $uri->productLimit;
			$filter = $uri->productFilter;
			$separator = $uri->productPaginationSeparator;
			$urlAppendChunk = '';
		} else {
			$baseUrl = $uri->urlBase;
			$tab = $uri->activeTab;
			$offset = $uri->offset;
			$limit = $uri->limit;
			$filter = $uri->filter;
			$separator = $uri->paginationSeparator;
			$productUrlPaginator = $uri->productUrlPaginator;
			global $childProductNodeCount;
			if ($childProductNodeCount > 0) {
				$urlAppendChunk = $productUrlPaginator;
			} else {
				$urlAppendChunk = '';
			}
		}
		$urlAppendChunk = '';

		$iteratorLink = '';

		//Middle links with numbers
		if ($total > $limit) {
			$middleLinks = '';
			//Show "limit" units of results per serp
			$middleCount = ceil($total / $limit);

			$offsetIndex = ceil($offset / $limit) + 1;
			if ($offsetIndex > 5) {
				$start = $offsetIndex - 5;
				$end = $offsetIndex + 5;
			} else {
				$start = 0;
				$end = 10;
			}
			if ($end > $middleCount) {
				$end = $middleCount;
				$start = $end - 10;
			}
			if ($start < 0) {
				$start = 0;
			}

			for ($i = $start; $i < $end; $i++) {
				$block = $i * $limit;
				if ($block == $offset) {
					$middleLinks .= ' '.($i+1);
				} else {
					$middleLinks .= ' <a href="/'.$baseUrl.$separator.$tab.'-'.$block.'-'.$limit.'-'.$filter.$urlAppendChunk.'#scroll">'.($i+1).'</a>';
				}
			}
		} else {
			$middleLinks = '1';
		}

		//Selectively show Prev/Next Buttons
		//Ommit $firstLink and $prevLink when showing first page
		if ($offset > 0) {
			if (!empty($urlAppendChunk)) {
				$firstLink =
					'<a href="/'.$baseUrl.$separator.$tab.'-0-'.$limit.'-'.$filter.
					$urlAppendChunk.'#scroll">&lt;&lt;</a>';
			} else {
				$firstLink = '<a href="/'.$baseUrl.'#scroll">&lt;&lt;</a>';
			}

			$prev = $offset - $limit;
			$prevLink =
				'<a href="/'.$baseUrl.$separator.$tab.'-'.$prev.'-'.$limit.'-'.$filter.
				$urlAppendChunk.'#scroll"><b>Previous</b></a>';
		} else {
			$firstLink = '';
			$prevLink = '';
		}

		//Ommit $lastLink and $nextLink when showing last page
		if (($offset+$limit) >= $total) {
			$count = ($offset+1).' - '.$total.' of '.$total;
			$lastLink = '';
			$nextLink = '';
		} else {
			$next = $offset + $limit;
			$nextLink =
				'<a href="/'.$baseUrl.$separator.$tab.'-'.$next.'-'.$limit.'-'.$filter.
				$urlAppendChunk.'#scroll"><b>Next</b></a>';

			$last1 = floor($total / $limit);
			$last = $last1 * $limit;
			if ($last >= $total) {
				$last = $last1-1;
				$last = $last * $limit;
			}
			$lastLink =
				'<a href="/'.$baseUrl.$separator.$tab.'-'.$last.'-'.$limit.'-'.$filter.
				$urlAppendChunk.'#scroll">&gt;&gt;</a>';

			$count = ($offset+1).' - '.($offset+$limit).' of '.$total;
		}

		$iteratorLink = $firstLink.' '.$prevLink.' '.$middleLinks.' '.$nextLink.' '.$lastLink;

		$paginationForm = '<form action="get.php" method="get">';

$viewing = $count.' ';
ob_start();
include('page-components/pagination.php');
$paginationForm = ob_get_clean();

		//Push $activePaginationUrl onto stack
		//array_unshift(PageComponents::$paginatorStack, $activePaginationUrl);

		$arrReturn = array($count, $iteratorLink, $paginationForm);

		return $arrReturn;
	}

	/**
	 * This method takes an array of words grouped by occurrence and
	 * converts it into html output of <h1> to <h6>
	 *
	 * All appropriate preprocessing of the text should have occurred
	 * somewhere else.
	 *
	 * @param associative array $arrWords
	 * @return html string
	 */
	public static function tagCloud($arrWords)
	{
		//reverse sort and maintain keys
		arsort($arrWords);
		$tag = 1;
		$count = 0;
		foreach ($arrWords as $k => $v) {
			//Skip single occuring tokens
			if ($v == 1) {
				continue;
			}

			if ($v > $count) {
				$count = $v;
			} elseif ($v < $count) {
				$count = $v;
				$tag++;
			}

			if ($tag > 6) {
				$hTag = 'h6';
			} else {
				$hTag = 'h'.$tag;
			}

			//Preserve original key for array update
			$key = $k;

			if (($hTag == 'h1') || ($hTag == 'h2')) {
				$k = strtoupper($k);
			}

			$v = '<'.$hTag.'>'.$k.'</'.$hTag.'>';
			$arrWords[$key] = $v;


			/*
			//use a mathematical algorithm to translate into h1-h6
//			$v = $v % 6;
			$v = sqrt($v);
			$v = floor($v);
			$v = 1/$v;
			$v = floor($v);
			$fontSize = $v.'em';
			echo '<span style="font-size: '.$fontSize.';">'.$k.'</span> ';
			*/
		}

		//Natural sort the tag cloud by key
		//This sorts the tag cloud alphabetically
		uksort($arrWords, "strnatcasecmp");

		$tag_cloud = join(' ', $arrWords);

		return $tag_cloud;
	}

	public static function metaExpires()
	{
		$metaExpires = Date::dateTime('html_meta', 86400);
		return $metaExpires;
	}

	public static function dropDownListFromArray($name, $arrObjects, $keyProperty=null, $keyMethod=null, $valueProperty=null, $valueMethod=null, $selectedOption='', $tabIndex='', $js='', $prependedOption='',$optiongrp="")
	{
		if ($tabIndex) {

			$tabIndexHtml = <<<END_TAB_INDEX
tabindex="$tabIndex"
END_TAB_INDEX;

		} else {

			$tabIndexHtml = '';

		}

		$dropDownList = <<<END_DROP_DOWN_LIST
<select id="$name" name="$name" $tabIndexHtml $js>$prependedOption
END_DROP_DOWN_LIST;
		$optgrp="";
		$g="";
		$first = true;
		foreach ($arrObjects as $object) {

			if (isset($keyProperty)) {
				$k = $object[$keyProperty];
			} 

			if (isset($valueProperty)) {
				$v = $object[$valueProperty];
			} 
			if(isset($optiongrp))
			{
				$g=$object[$optiongrp];
			}

			if ($k == $selectedOption) {
				$selected = ' selected';
			} else {
				$selected = '';
			}

			$htmlK = $k;
			$htmlV = $v;
			if($optgrp != $g)
			{
				
				$optgrp=$g;
				if($first){
					$dropDownList .= <<<END_DROP_DOWN_LIST

	<optgroup label="$g">
END_DROP_DOWN_LIST;
				}else
				{
$dropDownList .= <<<END_DROP_DOWN_LIST

	</optgroup>
END_DROP_DOWN_LIST;
				}


			
			
	}

			$dropDownList .= <<<END_DROP_DOWN_LIST

<option$selected value="$htmlK">$htmlV</option>
END_DROP_DOWN_LIST;

		}

		$dropDownList .=
'
</select>';

		return $dropDownList;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
