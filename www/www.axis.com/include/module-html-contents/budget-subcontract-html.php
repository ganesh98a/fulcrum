<?php

$cssDebugMode = false;
$javaScriptDebugMode = false;

// Display html as usual.
$SubcontractHtml = '';


$htmlHead = <<<END_HTML_HEAD
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<title>Subcontract -$project_name</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Bid Spread">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="imagetoolbar" content="false">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
END_HTML_HEAD;


	$htmlHead .= <<<END_HTML_HEAD

	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
	<link rel="stylesheet" href="/css/modules-purchasing-bid-spread.css">
	<link rel="stylesheet" href="/css/modules-permissions.css">
	<link rel="stylesheet" href="/css/fileuploader.css">
	<link rel="stylesheet" href="/css/bootstrap-popover.css">
	<link rel="stylesheet" href="/css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="/css/entypo.css">

	
	<link rel="stylesheet" href="/css/modules-budget.css">
	<link href="/css/fSelect.css" rel="stylesheet">
	<link href="/esignature/sign_src/css/jquery.signaturepad.css" rel="stylesheet">
END_HTML_HEAD;


$htmlHead .= <<<END_HTML_HEAD

	<style>
	.ui-autocomplete {
		overflow-y: auto;
		max-height: 150px;
		height: 150px;
		width: 300px;
	}
	</style>
<div id="modalDialogContainer" class="hidden"></div>
END_HTML_HEAD;

$SubcontractHtml .= $htmlHead;

//startsub
		$gc_budget_line_item_id = $get->gc_budget_line_item_id;
		$vendor_contact_company_id = $get->vendor_contact_company_id;
		$vendor_contact_id = $get->vendor_contact_id;
		$cost_code_division_id = $get->cost_code_division_id;
		$cost_code_id = $get->cost_code_id;
		$subcontractor_bid_id = $get->subcontractor_bid_id;

		if(isset($get->active_widget_number))
		{
			$active_widget_number = $get->active_widget_number;
		}else{
			$active_widget_number = 0;
		}

		if ($subcontractor_bid_id == 'undefined') {
			$subcontractor_bid_id = null;
		}

	
		$gcBudgetLineItem = GcBudgetLineItem::findGcBudgetLineItemByIdExtended($database, $gc_budget_line_item_id);


		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */
		$cost_code_id = $costCode->cost_code_id;
		$cost_code = $costCode->cost_code;
		$cost_code_description = $costCode->cost_code_description;
		$cost_code_description_abbreviation = $costCode->cost_code_description_abbreviation;

		$costCodeDivision = $gcBudgetLineItem->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */
		$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		$division_number = $costCodeDivision->division_number;
		$division_code_heading = $costCodeDivision->division_code_heading;
		$division = $costCodeDivision->division;
		$division_abbreviation = $costCodeDivision->division_abbreviation;

		$division_number = $costCodeDivision->division_number;
		$cost_code = $costCode->cost_code;
		$cost_code_description = $costCode->cost_code_description;
		$fileUploadDirectory = '/Subcontracts/' . $division_number . '-' . $cost_code . ' ' . $cost_code_description . '/';

		$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id);

		$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

		$title = $division_number.$costCodeDividerType.$cost_code." (".$cost_code_description.") - Subcontractor details";

		$SubcontractHtml .= <<<SUBCONTRACT_HTML
		<div><b>$title</b></div>
			<div id="divsignature"></div>
			<div id="dialog-confirm"></div>
			

			<input id="activeGcBudgetLineItem" type="hidden" value="$gc_budget_line_item_id-$cost_code_division_id-$cost_code_id">
			<div id="divSpreadButtons" style="float:left;margin-top:10px;">
			<input type="button" value="Go Back To Budget" onclick="navigateToBudget($project_id);">
			<input onclick="showHideCreateAdditionalSubcontractForm();" type="button" value="Create Additional Subcontract"></div>
			
			
SUBCONTRACT_HTML;
			

			$SubcontractHtml .= <<<SUBCONTRACT_HTML
			<div id="divModalWindow" style="clear:both;">
SUBCONTRACT_HTML;


		if (!empty($arrSubcontracts)) {
			$subcontract_sequence_number = Subcontract::findNextSubcontractSequenceNumber($database, $gc_budget_line_item_id);

			$subcontract = new Subcontract($database);
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;

			$createSubcontractForm = renderCreateSubcontractForm($database, $user_company_id, $subcontract, $cost_code_division_id, $cost_code_id, $subcontractor_bid_id);

			
			$SubcontractHtml .= <<<SUBCONTRACT_HTML
			<input id="formattedAttributeGroupName--manage-subcontract-record" type="hidden" value="Subcontract">
			
			<div id="createAdditionalSubcontractForm" style="display: none;">
			$createSubcontractForm
			</div>
SUBCONTRACT_HTML;


		}

		if (count($arrSubcontracts) > 1) {
			$listView = '<div style="font-weight:bold">Subcontracts List</div><div class="list-group subcontract-list-group">';

			$first = true;
			$activeSubcontractId = '';
			$countWidget = 0;
			foreach ($arrSubcontracts as $subcontract) {
				$tmp_subcontract_id = $subcontract->subcontract_id;
				$tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
				$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
				$vendor = $subcontract->getVendor();
				/* @var $vendor Vendor */
				$vendor_company_name = '';

				if ($vendor) {
					$vendorContactCompany = $vendor->getVendorContactCompany();
					/* @var $vendorContactCompany ContactCompany */
					if ($vendorContactCompany) {
					$vendor_company_name = " | ".$vendorContactCompany->company;
					}
				}
				if($active_widget_number == $countWidget){
					$activeClass = 'active';
					$activeSubcontractId = $tmp_subcontract_id;
				}else{
					$activeClass = '';
				}

				$subheader = "Sub #".$tmp_subcontract_sequence_number." (".$tmp_subcontract_actual_value.") ".$vendor_company_name;
				if ($first) {
					$first = false;
					$listView .= '<a onclick="showSubcontractDetails(this, \''.$tmp_subcontract_id.'\','.$countWidget.');" class="fakeHref list-group-item '.$activeClass.'">'.$subheader.'</a>';
				} else {
					$listView .= '<a onclick="showSubcontractDetails(this, \''.$tmp_subcontract_id.'\','.$countWidget.');" class="fakeHref list-group-item '.$activeClass.'">'.$subheader.'</a>';
				}
				$countWidget++;
			}

			$listView .= '</div>';
			$SubcontractHtml .= <<<SUBCONTRACT_HTML
			$listView
			<input type="hidden" id="activeGcBudgetLineSubcontractor" value="$activeSubcontractId">
			<input type="hidden" id="activeGcBudgetLineWidget" value="$active_widget_number">
SUBCONTRACT_HTML;

		
		}

		$first = true;
		$countWidget = 0;
		$gc_signatory =$vendor_signatory="";

		foreach ($arrSubcontracts as $subcontract) {

			$subcontract_id = $subcontract->subcontract_id;
			$gc_signatory = $subcontract->gc_signatory;
			$vendor_signatory  = $subcontract->vendor_signatory;

			$subcontractDetailsWidget = buildSubcontractDetailsWidget($database, $user_company_id, $subcontract_id);
			if($active_widget_number != $countWidget){
				$hiddenClass = 'class="hidden"';
			} else {
				$hiddenClass = '';
			}

			if ($first) {
				$first = false;
				if (count($arrSubcontracts) == 1) {
					$SubcontractHtml .= <<<SUBCONTRACT_HTML
				<input type="hidden" id="activeGcBudgetLineSubcontractor" value="$subcontract_id">
SUBCONTRACT_HTML;
					
				}
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
				<div id="container--subcontracts--main--$subcontract_id" 
				 $hiddenClass><div style="width:47%;float:left;padding-right: 35px;margin-top:10px;" id="container--subcontracts--$subcontract_id">$subcontractDetailsWidget
SUBCONTRACT_HTML;
			
			} else {
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
				<div id="container--subcontracts--main--$subcontract_id" $hiddenClass><div style="width:47%;float:left;padding-right: 35px;margin-top:10px;" id="container--subcontracts--$subcontract_id" >$subcontractDetailsWidget
SUBCONTRACT_HTML;
			
			}


			$vendor = $subcontract->getVendor();
			/* @var $vendor Vendor */
			$vendor_company_name = '';
			if ($vendor) {
				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */
				if ($vendorContactCompany) {
					$vendor_company_name = $vendorContactCompany->company;
				}
			}

			// Unsigned Subcontract Uploader
			$virtual_file_name =
				$vendor_company_name . ' : ' .
				'Unsigned Subcontract #'.
				$subcontract->subcontract_sequence_number . '.pdf';
			$encoded_virtual_file_name = urlencode($virtual_file_name);
			
			$finalUnsignedSubcontractFileUploader =
'
<div
	id="unsigned_subcontract_upload_'.$subcontract_id.'"
	class="boxViewUploader"
	folder_id=""
	project_id="'.$project_id.'"
	virtual_file_path="'.$fileUploadDirectory.'Unsigned/"
	virtual_file_name="'.$encoded_virtual_file_name.'"
	action="/modules-gc-budget-file-uploader-ajax.php"
	method="unsignedFinalSubcontract"
	allowed_extensions="pdf"
	drop_text_prefix=""
	multiple="false"
	post_upload_js_callback="subcontractDocumentUploaded(arrFileManagerFiles, \'manage-subcontract-record--subcontracts--unsigned_subcontract_file_manager_file--'.$subcontract_id.'\',\'unsign\')"
	style=""></div>
';

			// Signed Subcontract Uploader
			$virtual_file_name =
				$vendor_company_name . ' : ' .
				'Signed Subcontract #'.
				$subcontract->subcontract_sequence_number . '.pdf';
			$encoded_virtual_file_name = urlencode($virtual_file_name);
			$finalSignedSubcontractFileUploader =
'
<div
	id="signed_subcontract_upload_'.$subcontract_id.'"
	class="boxViewUploader"
	folder_id=""
	project_id="'.$project_id.'"
	virtual_file_path="'.$fileUploadDirectory.'Executed/"
	virtual_file_name="'.$encoded_virtual_file_name.'"
	action="/modules-gc-budget-file-uploader-ajax.php"
	method="signedFinalSubcontract"
	allowed_extensions="pdf"
	drop_text_prefix=""
	multiple="false"
	post_upload_js_callback="subcontractDocumentUploaded(arrFileManagerFiles, \'manage-subcontract-record--subcontracts--signed_subcontract_file_manager_file--'.$subcontract_id.'\',\'sign\')"
	style=""></div>
';

			$unsignedSubcontractFileManagerFile = $subcontract->getUnsignedSubcontractFileManagerFile();
			$signedSubcontractFileManagerFile = $subcontract->getSignedSubcontractFileManagerFile();
			/* @var $unsignedSubcontractFileManagerFile FileManagerFile */
			/* @var $signedSubcontractFileManagerFile FileManagerFile */

			if ($unsignedSubcontractFileManagerFile) {
				$unsigned_version_number = $unsignedSubcontractFileManagerFile->version_number;
				$file_location_id = $unsignedSubcontractFileManagerFile->file_location_id;
				if (!isset($unsigned_version_number) || ($unsigned_version_number == 1)) {
					$unsignedSubcontractUrl = $uri->cdn . '_' . $unsignedSubcontractFileManagerFile->file_manager_file_id;
				} else {
					$unsignedSubcontractUrl = $uri->cdn . '_' . $unsignedSubcontractFileManagerFile->file_manager_file_id . '?v=' . $unsigned_version_number;
				}

				$unsignedSubcontractFilename = $unsignedSubcontractFileManagerFile->virtual_file_name;
				$unsignedSubcontractFileManagerFileLink =
					'<a class="underline" target="_blank" href="'.$unsignedSubcontractUrl.'">'.$unsignedSubcontractFilename.'</a>';
					if($file_location_id=="")
					{
						$unsignedSubcontractUrl = '';
					}
			} else {
				$unsignedSubcontractFileManagerFileLink = '';
				$unsignedSubcontractUrl = '';
			}

			if ($signedSubcontractFileManagerFile) {
				$signed_version_number = $signedSubcontractFileManagerFile->version_number;
				if (!isset($signed_version_number) || ($signed_version_number == 1)) {
					$signedSubcontractUrl = $uri->cdn . '_' . $signedSubcontractFileManagerFile->file_manager_file_id;
				} else {
					$signedSubcontractUrl = $uri->cdn . '_' . $signedSubcontractFileManagerFile->file_manager_file_id . '?v=' . $signed_version_number;
				}

				$signedSubcontractFilename = $signedSubcontractFileManagerFile->virtual_file_name;
				$signedSubcontractFileManagerFileLink =
					'<a class="underline" target="_blank" href="'.$signedSubcontractUrl.'">'.$signedSubcontractFilename.'</a>';
			} else {
				$signedSubcontractFileManagerFileLink = '';
			}
			if($unsignedSubcontractFileManagerFileLink!=''){
			 $email_notice_unsign='display:block;';

			}else
			{
				$email_notice_unsign='display:none;';
			}
			if($signedSubcontractFileManagerFileLink!='')
			{
				$email_notice_sign='display:block;';
			}else
			{
				$email_notice_sign='display:none;';
			}

			$config = Zend_Registry::get('config');	
			$file_manager_base_path = $config->system->file_manager_base_path;
			$save = $file_manager_base_path.'backend/procedure/';

			//GC signatory
			$gc_filename = md5($gc_signatory);
			$signfile_name = $save.$gc_filename.'.png';
			$gcexist  = $vendorexist ='N';
			
			if(file_exists($signfile_name))
			{
				$gcexist  = 'Y';
			}

			$vendor_filename = md5($vendor_signatory);
			$vendorsignfile_name = $save.$vendor_filename.'.png';
			if(file_exists($vendorsignfile_name))
			{
				$vendorexist  = 'Y';
			}
			

			if(($currentlyActiveContactId == $gc_signatory) || ($currentlyActiveContactId == $vendor_signatory ))
			{
				
				$canComplie= "Y";
				$signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="GC Signed" value ="Apply e-signature" onclick="showsetSignaturewithdialog('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;&apos;,&apos;&apos;,&apos;'.$canComplie.'&apos;)">Apply/Modify E-sign</a>';
			}else
			{
				
				$canComplie= "N";
				$signatory_text="";
			}

			$subcontract_execution_date=\Date::convertDateTimeFormat($subcontract->subcontract_execution_date,'html_form');
			$subcontract_mailed_date=\Date::convertDateTimeFormat($subcontract->subcontract_mailed_date,'html_form');

			$SubcontractHtml .= <<<SUBCONTRACT_HTML

<div id="Viewsubcontractor-$subcontract_id" class="modal" style="display: none;"></div>
<div class="widgetContainer final-subcontract-blog" style="margin:20px 0;">
	<h3 class="title">Final Subcontract</h3>
	<table class="content" width:"100%" cellpadding="5">
	<tr>
		<th class="textAlignLeft" width="30%">Compile Final Subcontract:</th>
		<td width="70%" colspan="2"><input type="button" onclick="verifyFinalSubcontract($gc_budget_line_item_id, $cost_code_division_id, $cost_code_id, $subcontract_id, $subcontract->subcontract_execution_date, $subcontract->subcontract_mailed_date,&apos;$gcexist&apos;,&apos;$vendorexist&apos;,&apos;$canComplie&apos;);" value="Compile Final Subcontract">
		<input type="button" class="Compile_$subcontract_id" onclick="generateFinalSubcontract($gc_budget_line_item_id, $cost_code_division_id, $cost_code_id, $subcontract_id, $subcontract->subcontract_execution_date, $subcontract->subcontract_mailed_date,&apos;$gcexist&apos;,&apos;$vendorexist&apos;,&apos;$canComplie&apos;);" value="Compile Final Subcontract" style="display:none;">

		
		<input type="checkbox" id="signatory_$subcontract_id" name="signatory_$subcontract_id" style="display:none;" >

	</td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Upload Unsigned Subcontract:</th>
		<td nowrap width="70%" colspan="2">$finalUnsignedSubcontractFileUploader</td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="33%">View Unsigned Subcontract:</th>
		<td id="manage-subcontract-record--subcontracts--unsigned_subcontract_file_manager_file--$subcontract_id"  class="tooltip-user" width="33%"  nowrap>$unsignedSubcontractFileManagerFileLink</td>
		<td id="unsign" style="$email_notice_unsign" width="33%"><input type="button" id="save" onclick="TransmittalNotice('unsigned',$gc_budget_line_item_id,$subcontract_id,$primary_contact_id,'$primary_contact_name');" style="font-size: 10pt;"  value="Email Subcontract Notice"></td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Upload Final Signed Subcontract:</th>
		<td nowrap width="70%" colspan="2">$finalSignedSubcontractFileUploader</td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Subcontract Execution Date:</th>

		<td nowrap width="70%" colspan="2"><input id="manage-subcontract-record--subcontracts--subcontract_execution_date--$subcontract_id" type="text"  class="datepicker" value="$subcontract_execution_date"  onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', '', '', false);"></td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Subcontract Mailed Date:</th>

		<td nowrap width="70%" colspan="2"><input id="manage-subcontract-record--subcontracts--subcontract_mailed_date--$subcontract_id" type="text" class="datepicker" value="$subcontract_mailed_date" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', '', '', false);"></td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="33%">View Final Signed Subcontract:</th>
		<td id="manage-subcontract-record--subcontracts--signed_subcontract_file_manager_file--$subcontract_id" class="tooltip-user" nowrap width="33%">$signedSubcontractFileManagerFileLink</td>
		<td id="sign" style="$email_notice_sign"><input type="button" id="save" onclick="TransmittalNotice('signed',$gc_budget_line_item_id,$subcontract_id,$primary_contact_id,'$primary_contact_name');" style="font-size: 10pt;"  value="Email Subcontract Notice" width="33%"></td>
	</tr>
	</table>
</div>
</div>
SUBCONTRACT_HTML;
			if($unsignedSubcontractUrl =="")
			{
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
									<div id="pdfcontainer" class="pdfcontainer preview-subcontract">
										<div style="margin-top:10px;margin-bottom:10px;text-align: right;">$signatory_text</div>
										No Preview Available
									</div>
SUBCONTRACT_HTML;
			}else{

				$SubcontractHtml .= <<<SUBCONTRACT_HTML
									<div id="pdfcontainer" class="pdfcontainer preview-subcontract">
										<div style="margin-top:10px;margin-bottom:10px;text-align: right;">$signatory_text</div>
										<iframe id="iframeFilePreview" src="$unsignedSubcontractUrl" style="border:0;" width="100%" height="1010px;"></iframe>
									</div>
SUBCONTRACT_HTML;
			}

			$SubcontractHtml .= <<<SUBCONTRACT_HTML
<div class="widgetContainer subdoclist" style="margin:0;clear: both;">
	<table class="content subcontract-document" cellpadding="5" width="100%" style="margin:0;">
	<thead class="borderBottom">
	<tr><h3 class="title">Subcontract Documents</h3></tr>
	<tr>
	<th nowrap style="width: 4%;" class="textAlignCenter">Order</th>
	<th nowrap class="textAlignLeft" style="width: 15%;">Subcontract Document</th>
	<th nowrap class="textAlignCenter">
		Auto Gen.
		<div class="dropdown" style="display:inline">
		  <button class="btn btn-default dropdown-toggle bs-dropdown-notitle" type="button" id="dropdownMenu1" data-toggle="dropdown">
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="renderAllDocumentsForSelectedSubcontract(\'$subcontract_id\'); return false;">Render all</a></li>
		  </ul>
		</div>
	</th>
	<th class="textAlignCenter" style="width: 10%;">Upload Unsigned Doc.</th>
	<th style="width: 10%;" nowrap class="textAlignCenter">View<br> Unsigned Doc.</th>

	<th class="textAlignCenter">GC <br>E-sign</th>
	<th class="textAlignCenter">Vendor <br>E-sign</th>

	<th class="textAlignCenter" style="width: 10%;">Upload Signed Doc.</th>
	<th nowrap class="textAlignCenter" style="width: 10%;">View<br> Signed Doc.</th>
	</tr>
	</thead>
	<tbody class="tbodySortable altColors">
SUBCONTRACT_HTML;



		
			$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
			$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;
			$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions);

			
			
			//Get Subcontract cover template id
			$coverId = SubcontractDocument::SubcontractDocumentcoverId($database,$subcontract_id,'2');

			$counter = 0;
			foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {
				/* @var $subcontractDocument SubcontractDocument */
				$subcontractItemTemplate = $subcontractDocument->getSubcontractItemTemplate();

			
				$subcontract_item_template_id = $subcontractDocument->subcontract_item_template_id;
				$unsigned_subcontract_document_file_manager_file_id = $subcontractDocument->unsigned_subcontract_document_file_manager_file_id;
				$signed_subcontract_document_file_manager_file_id = $subcontractDocument->signed_subcontract_document_file_manager_file_id;
				$auto_generated_flag = $subcontractDocument->auto_generated_flag;
				$disabled_flag = $subcontractDocument->disabled_flag;
				$sort_order = $subcontractDocument->sort_order;

				$tempgc_signatory = $subcontractDocument->gc_signatory;
				$tempvendor_signatory = $subcontractDocument->vendor_signatory;
				$gc_signatory_check="";
				$vendor_signatory_check="";
				$gc_signatory_text= $vendor_signatory_text = "-";
				if($coverId == $subcontract_document_id){
					if($tempgc_signatory=='Y' )
					{
					
						if($currentlyActiveContactId == $gc_signatory)
						{					
							$gc_signatory_check="checked='true'";
							$gc_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="GC Signed" value ="Apply e-signature" onclick="showsetSignaturewithdialog('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Signed</a>';
						}else
						{
							$gc_signatory_text= "Signed";
						}
					}else if($currentlyActiveContactId == $gc_signatory){

						$gc_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="GC yet to sign" value ="Apply e-signature" onclick="showsetSignature('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Apply E-sign</a>';
					}else{
						$gc_signatory_text='Awaiting';
					}
					if($tempvendor_signatory=='Y')
					{
						$vendor_signatory_check="checked='true'";

						if($currentlyActiveContactId == $vendor_signatory)
						{
							$vendor_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="vendor Signed" value ="Apply e-signature" onclick="showsetSignaturewithdialog('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Signed</a>';
						}else{
							$vendor_signatory_text='Signed';
						}
					}else if($currentlyActiveContactId == $vendor_signatory){
						$vendor_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="vendor yet to sign" value ="Apply e-signature" onclick="showsetSignature('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Apply E-sign</a>';
					}else{
						$vendor_signatory_text = "Awaiting";
					}
				}
		
			

				$unsignedSubcontractDocumentFileManagerFile = $subcontractDocument->getUnsignedSubcontractDocumentFileManagerFile();
				/* @var $unsignedSubcontractDocumentFileManagerFile FileManagerFile */

				if ($unsignedSubcontractDocumentFileManagerFile) {
					$unsigned_version_number = $unsignedSubcontractDocumentFileManagerFile->version_number;
					if (!isset($unsigned_version_number) || ($unsigned_version_number == 1)) {
						$unsignedSubcontractDocumentUrl = $uri->cdn . '_' . $unsignedSubcontractDocumentFileManagerFile->file_manager_file_id;
					} else {
						$unsignedSubcontractDocumentUrl = $uri->cdn . '_' . $unsignedSubcontractDocumentFileManagerFile->file_manager_file_id . '?v=' . $unsigned_version_number;
					}
					$unsignedSubcontractDocumentFilename = $unsignedSubcontractDocumentFileManagerFile->virtual_file_name;
					$unsignedSubcontractDocumentFileManagerFileLink =
						'<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$unsignedSubcontractDocumentUrl.'" title="'.$unsignedSubcontractDocumentFilename.'">Document</a>';
				} else {
					$unsignedSubcontractDocumentFileManagerFileLink = '';
				}

				$signedSubcontractDocumentFileManagerFile = $subcontractDocument->getSignedSubcontractDocumentFileManagerFile();
				/* @var $signedSubcontractDocumentFileManagerFile FileManagerFile */

				if ($signedSubcontractDocumentFileManagerFile) {
					$signed_version_number = $signedSubcontractDocumentFileManagerFile->version_number;
					if (!isset($signed_version_number) || ($signed_version_number == 1)) {
						$signedSubcontractDocumentUrl = $uri->cdn . '_' . $signedSubcontractDocumentFileManagerFile->file_manager_file_id;
					} else {
						$signedSubcontractDocumentUrl = $uri->cdn . '_' . $signedSubcontractDocumentFileManagerFile->file_manager_file_id . '?v=' . $signed_version_number;
					}
					$signedSubcontractDocumentFilename = $signedSubcontractDocumentFileManagerFile->virtual_file_name;
					$signedSubcontractDocumentFileManagerFileLink =
						'<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$signedSubcontractDocumentUrl.'" title="'.$signedSubcontractDocumentFilename.'">Document</a>';
						if($coverId != $subcontract_document_id){
							$gc_signatory_text= $vendor_signatory_text = "NA";
						}
				} else {
					$signedSubcontractDocumentFileManagerFileLink = '';
				}

		

				$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
				$user_company_id_template = (int) $subcontractItemTemplate->user_company_id;
				$file_manager_file_id = (int) $subcontractItemTemplate->file_manager_file_id;
				$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
				$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
				$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
				$subcontract_item_template_type = (string) $subcontractItemTemplate->subcontract_item_template_type;
				$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;

				$fileManagerFile = $subcontractItemTemplate->getFileManagerFile();
				/* @var $fileManagerFile FileManagerFile */
				$userCompanyFileTemplate = $subcontractItemTemplate->getUserCompanyFileTemplate();
				/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
				<tr id="manage-subcontract-document-record--subcontract_documents--sort_order--$subcontract_document_id--$counter" class="trSortable">
					<td class="tdSortBars textAlignCenter verticalAlignMiddle" nowrap><img src="/images/sortbars.png"></td>
					<td nowrap class="textAlignLeft verticalAlignMiddle">$subcontract_item</td>
					<td nowrap class="textAlignCenter verticalAlignMiddle">
SUBCONTRACT_HTML;


				$counter++;

				if (($subcontract_item_template_type == 'Dynamic Template File') && (!is_int(strpos($subcontract_item, 'Cover Letter')))) {
					
					$SubcontractHtml .= <<<SUBCONTRACT_HTML
						<input id="buttonGenerateDynamicSubcontractDocument--$subcontract_document_id" onclick="generateDynamicSubcontractDocument('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$subcontract_id', '$subcontract_item_template_id');" type="button" class="buttonRenderDocument" value="Render Document">
SUBCONTRACT_HTML;


				}

				$SubcontractHtml .= <<<SUBCONTRACT_HTML
					</td>
					<td class="textAlignLeft verticalAlignMiddle" >
SUBCONTRACT_HTML;

				if (($subcontract_item_template_type == 'File Uploaded During Subcontract Creation')||($subcontract_item_template_type == 'By Project Static Subcontract Document')) {
					// Pass in id values for the ajax file uploader to easily find data
					//File name shorter to be subcontractor and doc name
					$virtual_file_name =
						$vendor_company_name . ' : ' .
						$subcontractItemTemplate->subcontract_item . '.pdf';
					$encoded_virtual_file_name = urlencode($virtual_file_name);

					$byPrjSt ="0";
					if ($subcontract_item_template_type == 'By Project Static Subcontract Document') {
						$byPrjSt ="1";

					}
					$SubcontractHtml .= '
						<div id="unsigned_subcontract_document_upload_'.$subcontract_id.'_'.$subcontract_item_template_id.'"
							class="boxViewUploader"
							folder_id=""
							project_id="'.$project_id.'"
							virtual_file_path="'.$fileUploadDirectory.'Unsigned/"
							virtual_file_name="'.$encoded_virtual_file_name.'"
							action="/modules-gc-budget-file-uploader-ajax.php"
							method="unsignedSubcontractDocument"
							allowed_extensions="pdf"
							drop_text_prefix=""
							multiple="false"
							post_upload_js_callback="unsignedSubcontractDocumentUploaded(arrFileManagerFiles, \'tdLinkToUnsignedDocument--'.$subcontract_id.'-'.$subcontract_item_template_id.'\','.$byPrjSt.','.$subcontract_item_template_id.')"
							style=""></div>';

				}
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
					</td>
					<td nowrap class="textAlignCenter verticalAlignMiddle tdLinkToUnsignedDocument" id="tdLinkToUnsignedDocument--$subcontract_id-$subcontract_item_template_id">
SUBCONTRACT_HTML;


				
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
					$unsignedSubcontractDocumentFileManagerFileLink
SUBCONTRACT_HTML;
					 
				
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
						</td>
						<td nowrap class="textAlignCenter verticalAlignMiddle"> 
							$gc_signatory_text
						</td>
						<td nowrap class="textAlignCenter verticalAlignMiddle"> 
							$vendor_signatory_text
						</td>
						<td nowrap class="textAlignLeft verticalAlignMiddle" >
SUBCONTRACT_HTML;



				$virtual_file_name =
				$vendor_company_name . ' : ' .
				$subcontractItemTemplate->subcontract_item . '.pdf';
				$encoded_virtual_file_name = urlencode($virtual_file_name);
				$SubcontractHtml .= '
					<div
	id="signed_subcontract_document_upload_'.$subcontract_id.'_'.$subcontract_item_template_id.'"
	class="boxViewUploader"
	folder_id=""
	project_id="'.$project_id.'"
	virtual_file_path="'.$fileUploadDirectory.'Executed/"
	virtual_file_name="'.$encoded_virtual_file_name.'"
	action="/modules-gc-budget-file-uploader-ajax.php"
	method="signedSubcontractDocument"
	allowed_extensions="pdf"
	drop_text_prefix=""
	multiple="false"
	post_upload_js_callback="signedSubcontractDocumentUploaded(arrFileManagerFiles, \'tdLinkToSignedDocument--'.$subcontract_id.'-'.$subcontract_item_template_id.'\')"
	style=""></div>
	</td>
<td nowrap class="textAlignCenter verticalAlignMiddle tdLinkToSignedDocument" id="tdLinkToSignedDocument--$subcontract_id-$subcontract_item_template_id">
';

				
				
				
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
						$signedSubcontractDocumentFileManagerFileLink
SUBCONTRACT_HTML;
					
				$SubcontractHtml .= <<<SUBCONTRACT_HTML
					</td>
				</tr>
SUBCONTRACT_HTML;

			}
			$SubcontractHtml .= <<<SUBCONTRACT_HTML
			</tbody>
		</table>
	</div>
	<br>
	<input type="hidden" id="active_gc_budget_line_item_id" value="$gc_budget_line_item_id">
</div>
SUBCONTRACT_HTML;


	$countWidget++;
		}

		if (empty($arrSubcontracts)) {

			// Create Subcontract / Form

			$subcontract_sequence_number = 1;
			$subcontractorBid = false;
			$vendor = false;

			// Vendor
			if (isset($vendor_id) && !empty($vendor_id)) {
				$vendor = Vendor::findById($database, $vendor_id);
			} elseif (isset($vendor_contact_company_id) || isset($vendor_contact_id)) {
				$vendor = Vendor::findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id);

				if ($vendor) {

					$vendor_id = $vendor->vendor_id;

				} else {

					$vendor = new Vendor($database);

					if (isset($vendor_contact_company_id) || isset($vendor_contact_id)) {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
					}
					if (isset($vendor_contact_id)) {
						$vendor->vendor_contact_id = $vendor_contact_id;
					}

					$vendor->convertPropertiesToData();

					$vendor_id = $vendor->save();

				}
			} elseif (isset($subcontractor_bid_id)) {
				$subcontractorBid = SubcontractorBid::findSubcontractorBidByIdExtended($database, $subcontractor_bid_id);
				if ($subcontractorBid) {
					$subcontractorContact = $subcontractorBid->getSubcontractorContact();
					/* @var $subcontractorContact Contact */

					$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
					/* @var $subcontractorContactCompany ContactCompany */

					if ($subcontractorContact) {
						$vendor_contact_id = $subcontractorContact->contact_id;
					}

					if ($subcontractorContactCompany) {
						$vendor_contact_company_id = $subcontractorContactCompany->contact_company_id;
					}

					$vendor = Vendor::findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id);

					if ($vendor) {

						$vendor_id = $vendor->vendor_id;

					} else {

						$vendor = new Vendor($database);

						if (isset($vendor_contact_company_id) || isset($vendor_contact_id)) {
							$vendor->vendor_contact_company_id = $vendor_contact_company_id;
						}
						if (isset($vendor_contact_id)) {
							$vendor->vendor_contact_id = $vendor_contact_id;
						}

						$vendor->convertPropertiesToData();

						$vendor_id = $vendor->save();

					}
				}
			} else {
				$vendor = false;
			}

			$subcontract = new Subcontract($database);
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
			$subcontract->setVendor($vendor);
			if ($subcontractorBid) {
				$subcontract->setSubcontractorBid($subcontractorBid);
			}
			if($user_company_id_template == null || $user_company_id_template == ''){
				$user_company_id_template = $user_company_id;
			}
			$createSubcontractForm = renderCreateSubcontractForm($database, $user_company_id_template, $subcontract, $cost_code_division_id, $cost_code_id, $subcontractor_bid_id);
			$SubcontractHtml .= <<<END_BID_SPREAD_HTML
			$createSubcontractForm
END_BID_SPREAD_HTML;
	

		}
//Endsub


$SubcontractHtml .= <<<END_BID_SPREAD_HTML
	<input id="project_id" type="hidden" value="$currentlySelectedProjectId">
	<input id="gc_budget_line_item_id" type="hidden" value="$gc_budget_line_item_id">
	<input id="cost_code_division_id" type="hidden" value="$cost_code_division_id">
	<input id="cost_code_id" type="hidden" value="$cost_code_id">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--$currentlySelectedProjectId" type="hidden" value="">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--net_rentable_square_footage--$currentlySelectedProjectId" type="hidden" value="">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--unit_count--$currentlySelectedProjectId" type="hidden" value="">
	<input id="csvPreferredSubcontractorBidIds" type="hidden" value="">

	<input id="openModal" type="hidden" value="">
	<input id="bid_spread_id" type="hidden" value="">
	<input id="active_bid_spread_id" type="hidden" value="">
	<input id="selected_bid_spread_id" type="hidden" value="-1">
	<input id="selected_bid_spread_status_id" type="hidden" value="-1">
	<input id="modal_bid_spread_sequence_number" type="hidden" value="">
	<input id="bid_spread_sequence_number" type="hidden" value="">
	<input id="csvSubcontractorBidIds" type="hidden" value="">

	<div id="messageDiv" class="userMessage"></div>
	
	<div id="divModalWindow2" class="hidden divModalWindow2Tracking" rel="tooltip" title="">&nbsp;</div>
	<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>
	<div id="divBidSpreadApprovalProcessDialog" class="hidden"></div>
	</div>
END_BID_SPREAD_HTML;

	
	$htmlBodyFooter = <<<END_HTML_BODY_FOOTER
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	<script src="/js/ddaccordion.js"></script>
	<script src="/js/library-main.js"></script>
	<script src="/js/permissions.js"></script>
	<script src="/js/admin-projects-team-management.js"></script>
	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
	<![endif]-->
	<script src="/js/accounting.js"></script>
	<script src="/js/library-data_types.js"></script>
	<script src="/js/library-tabular_data.js"></script>
	<script src="/js/fileuploader.js"></script>
	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>
	<script src="/js/library-code-generator.js"></script>
	<script src="/js/generated/bid_items-js.js"></script>
	<script src="/js/generated/bid_items_to_subcontractor_bids-js.js"></script>
	<script src="/js/generated/subcontracts-js.js"></script>
	<script src="/js/generated/subcontractor_bids-js.js"></script>
	<script src="/js/modules-gc-budget.js"></script>
	<script src="/js/modules-purchasing-bid-spread.js"></script>
	<script src="/js/jquery.maskedinput.js"></script>
	<script src="/js/generated/contact_companies-js.js"></script>
	<script src="/js/generated/contact_company_offices-js.js"></script>
	<script src="/js/generated/contact_company_office_phone_numbers-js.js"></script>
	<script src="/js/generated/contact_phone_numbers-js.js"></script>
	<script src="/js/generated/contacts-js.js"></script>
	<script src="/js/generated/cost_code_divisions-js.js"></script>
	<script src="/js/generated/cost_codes-js.js"></script>
	<script src="/js/generated/gc_budget_line_items-js.js"></script>
	<script src="/js/generated/mobile_phone_numbers-js.js"></script>
	<script src="/js/generated/subcontract_documents-js.js"></script>
	<script src="/js/generated/subcontracts-js.js"></script>
	<script src="/js/modules-contacts-manager-common.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>
	<script src="/js/modules-purchasing.js"></script>
	<script src="/js/fSelect.js"></script>
	<script src="/js/budget_subcontract.js"></script>
	<script src="/esignature/sign_src/js/html2canvas.js"></script>
	<script src="/esignature/sign_src/js/texthtml2canvas.js"></script>
	<script src="/esignature/sign_src/js/numeric-1.2.6.min.js"></script> 
	<script src="/esignature/sign_src/js/bezier.js"></script>
	<script src="/esignature/sign_src/js/json2.min.js"></script>
	<script src="/esignature/sign_src/js/jquery.signaturepad.js"></script> 
	<script src="/app/js/account-management-esign.js"></script>
END_HTML_BODY_FOOTER;

$htmlBodyFooter .= <<<END_HTML_BODY_FOOTER
	<script>
		window.debugMode = false;
		window.showJSExceptions = true;
		window.modalDialogUrlDebugMode = false;
		window.ajaxUrlDebugMode = false;
	</script>

</body>
</html>
END_HTML_BODY_FOOTER;

$SubcontractHtml .= $htmlBodyFooter;
