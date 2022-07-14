<?php
$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/Draws.php');
require_once('lib/common/DrawItems.php');
require_once('lib/common/DrawStatus.php');
require_once('lib/common/DrawRetainerRate.php');
require_once('lib/common/DrawActionTypes.php');
require_once('lib/common/DrawActionTypeOptions.php');
require_once('lib/common/DrawBreakDowns.php');
require_once('lib/common/Format.php');
require_once('lib/common/Project.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('app/models/permission_mdl.php');
require_once('lib/common/RetentionDraws.php');
require_once('lib/common/RetentionItems.php');
require_once('lib/common/Service/UniversalService.php');
//renders draw list grid
function renderDrawListHtml($database,$projectId,$statusId=""){
  $userCanViewDraws = checkPermissionForAllModuleAndRole($database,'view_draws');
  $userCanEditDraws = checkPermissionForAllModuleAndRole($database,'edit_draws');
  $userCanPostDraws = checkPermissionForAllModuleAndRole($database,'post_draws');
  $session = Zend_Registry::get('session');
  $userRole = $session->getUserRole();
  $debugMode = $session->getDebugMode();
  // if($userRole =="global_admin")
  // {
    $userCanViewDraws = $userCanEditDraws = $userCanPostDraws=1;
  // }
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';

  $drawsList = Draws::getDrawsList($database,$projectId,$statusId,$corType);
  $actionThHtml = "";
  $actionTdHtml = "";
  $project = Project::findById($database, $projectId);
  /*To get retention List*/
  $retentionList =  RetentionDraws::getRetentionList($database,$projectId,$statusId);


  $drawListTableBody = '';
  $increTh = 0;
  foreach ($drawsList as $key => $value) {
    $applicationNumber = $value['application_number'];
    $thorughDate = date("m/d/Y", strtotime($value['through_date']));
    $drawId = $value['id'];
    $totalCurrentApp = Format::formatCurrency($value['total_current_app']);
    $totalCurrentRetainerValue = Format::formatCurrency($value['total_current_retainer_value']);
    $previousDraw = Draws::getSumOfPreviousDrawValue($database,$projectId,$applicationNumber,$corType);

    $drawGridRawContent = getOriginal_contract_value($database,$projectId, $drawId, $applicationNumber,false,false,$corType,false);

    $getChangeOrderDrawItems = renderChangeOrderValuesForPDF($database,$projectId, $drawId, $applicationNumber);

    $totalScheduledValue = DrawItems::getTotalScheduledValue($database,$projectId,$drawId,$corType);
    $completionPercentage = (($value['total_current_app']+$previousDraw['total_current_app'])/$totalScheduledValue)*100;
    $totalScheduledValueFormatted = Format::formatCurrency($totalScheduledValue);

    $drawGridRawContentFormatted = Format::formatCurrency($drawGridRawContent['totalOriginalScheduledValue']);
    $getChangeOrderDrawItemsFormatted = Format::formatCurrency($getChangeOrderDrawItems['totalAdditionValue'] - $getChangeOrderDrawItems['totalDeductionValue']);
    $completionPercentageFormatted = numberFormat($completionPercentage);
    $totalPreviousApp = Format::formatCurrency($previousDraw['total_current_app']);
    // $totalPreviousRetainerValue =Format::formatCurrency($previousDraw['total_current_retainer_value']);
    $drawStatus = $value['status'];
    if($userCanEditDraws || $userRole == "global_admin"){
      $editClick = "class='cursor' onclick='editDraw($applicationNumber)'";
    }else{
      $editClick = '';
    }
    $actionTdHtml = '<td></td>';

    if($userCanEditDraws || $userCanPostDraws)
    {
    if($drawStatus == 'Draft') {
      $increTh++;
      $actionTdHtml = <<<DRAWHTML
      <td class="textAlignCenter" nowrap><a onclick="deleteDrawWithConfirmation($drawId, $applicationNumber)"><span class="entypo-cancel-circled"></span></a></td>
DRAWHTML;
    }
  }
  $retention_html = $retention_draw_list = '';
  $overallRetainerValue = $previousDraw['total_current_retainer_value'] + $value['total_current_retainer_value'];
  
  $retentionBilledTodate = $previousDraw['total_current_app'] + $value['total_current_app'];
  $retentionBilledTodateFormatted = Format::formatCurrency($retentionBilledTodate);
  $prevDrawRetvalue = $previousDraw['total_current_retainer_value']+$value['total_current_retainer_value'];

   $retTotReduceindraw=0;
  //Retention Draw details
   $rincreTh =0;
   $retactionTdHtml ="";
  foreach ($retentionList as $key => $retval) {
    $last_draw_id = $retval['last_draw_id'];
    //To reduce the retention amount for the next draw
    if($drawId > $last_draw_id)
    {
      $retTotReduceindraw = RetentionItems::sumofRetentionItems($database,$projectId,$last_draw_id);
      break;
    }
    // TO restrict the retention draw above the Draws
    if($drawId  != $last_draw_id)
    {
      continue;
    }
    $rapplicationNumber = $retval['application_number'];
    $thorughDate = date("m/d/Y", strtotime($retval['through_date']));
    $retId = $retval['id'];
    $last_draw_id = $retval['last_draw_id'];
    $totalScheduledValue = Format::formatCurrency($retval['total_scheduled_retention_value']);
    $totalCurrentRetainer = Format::formatCurrency($retval['total_current_retainage']);
    $totalPreviousRetainage= Format::formatCurrency($retval['total_previous_retainage']);
    $rettotalCurrentRetainerValue = Format::formatCurrency($retval['total_current_retainer_value']);
    $totalPercentageCompleted = Format::formatCurrency($retval['total_percentage_completed']);
     // (pre draw) total retention - (ret)cur.app
     if($prevDrawRetvalue >$retval['total_current_retainer_value'])
     {

       $retTotalRet = $prevDrawRetvalue - $retval['total_current_retainer_value'];
    }else
    {
       $retTotalRet = $retval['total_current_retainer_value']-$prevDrawRetvalue ;
    }
    $retTotalRetFormatted = Format::formatCurrency($retTotalRet);

    $getDraw = Draws::findById($database, $last_draw_id);
    $drawapplicationNumber =  $getDraw['application_number'];
    $previousdataDraw = Draws::getSumOfPreviousDrawValue($database,$projectId,$drawapplicationNumber,$corType);

    if(!empty($totalScheduledValue)){
      $completionPercentage = (($retval['total_previous_retainage']+$previousdataDraw['total_current_retainer_value'])/$totalScheduledValue)*100;  
    }else{
      $completionPercentage = 0;
    }
    
    $retcompletionPercentageFormatted = numberFormat($completionPercentage);

    $RetStatus = $retval['status'];
    if($userCanEditDraws || $userRole == "global_admin"){
      $reteditClick = "class='cursor' onclick='editRetention($rapplicationNumber)'";
    }else{
      $reteditClick = '';
    }
    $retactionTdHtml = '<td></td>';

    if($userCanEditDraws || $userCanPostDraws)
    {
    if($RetStatus == 'Draft') {
      $rincreTh++;
      $retactionTdHtml = <<<DRAWHTML
      <td class="textAlignCenter" nowrap><a onclick="deleteRetWithConfirmation($retId, $rapplicationNumber)"><span class="entypo-cancel-circled"></span></a></td>
DRAWHTML;
    }
  }
  $retention_html = $retention_draw_list = '';
  $overallRetainerValue = $previousdataDraw['total_current_retainer_value'] + $value['total_current_retainer_value'];
  
    $drawListTableBody .= <<<END_SUBMITTAL_TABLE_TBODY
     <tr id="$retId" class="RetStyle">
END_SUBMITTAL_TABLE_TBODY;
    if($debugMode){
      $drawListTableBody .= <<<END_SUBMITTAL_TABLE_TBODY
      <td $reteditClick nowrap> Ret $retId</td>
END_SUBMITTAL_TABLE_TBODY;
    }
    $drawListTableBody .= <<<END_SUBMITTAL_TABLE_TBODY
    <td $reteditClick nowrap>Ret $rapplicationNumber</td>
    <td $reteditClick nowrap>$thorughDate</td>
    <td $reteditClick nowrap>$RetStatus</td>
    <td $reteditClick nowrap>$drawGridRawContentFormatted</td>
    <td $reteditClick nowrap>$getChangeOrderDrawItemsFormatted</td>
    <td $reteditClick nowrap>$totalScheduledValueFormatted</td>
    <td $reteditClick nowrap>$retentionBilledTodateFormatted</td>
    <td $reteditClick nowrap> </td>    
    <td $reteditClick nowrap>$rettotalCurrentRetainerValue</td>
    <td $reteditClick nowrap> </td>
    <td $reteditClick nowrap>$retTotalRetFormatted</td>
    $retactionTdHtml
  </tr>
END_SUBMITTAL_TABLE_TBODY;
}

  // End of retention details

   $totalPreviousRetainerValue =  $previousDraw['total_current_retainer_value'] - $retTotReduceindraw+$value['total_current_retainer_value'];
   $totalPreviousRetainerValue =Format::formatCurrency($totalPreviousRetainerValue);
    $drawListTableBody .= <<<END_SUBMITTAL_TABLE_TBODY
     <tr id="$drawId">
END_SUBMITTAL_TABLE_TBODY;
    if($debugMode){
      $drawListTableBody .= <<<END_SUBMITTAL_TABLE_TBODY
      <td $editClick nowrap>$drawId</td>
END_SUBMITTAL_TABLE_TBODY;
    }
    $drawListTableBody .= <<<END_SUBMITTAL_TABLE_TBODY
    <td $editClick nowrap>$applicationNumber </td>
    <td $editClick nowrap>$thorughDate</td>
    <td $editClick nowrap>$drawStatus</td>
    <td $editClick nowrap>$drawGridRawContentFormatted</td>
    <td $editClick nowrap>$getChangeOrderDrawItemsFormatted</td>
    <td $editClick nowrap>$totalScheduledValueFormatted</td>
    <td $editClick nowrap>$totalPreviousApp</td>
    <td $editClick nowrap>$completionPercentageFormatted</td>   
    <td $editClick nowrap>$totalCurrentApp</td>
    <td $editClick nowrap>$totalCurrentRetainerValue</td>
    <td $editClick nowrap>$totalPreviousRetainerValue</td>
    $actionTdHtml
  </tr>
END_SUBMITTAL_TABLE_TBODY;
  }
  $textAlign = 'style="text-align: center;"';
    $actionThHtml = <<<DRAWHTML
    <th $textAlign nowrap>Action</th>
DRAWHTML;
  if($debugMode){
    $debugHeadline = "<th $textAlign nowrap>DRAW ID</th>";
  }else{
    $debugHeadline = '';
  }
  $htmlContent = <<<END_HTML_CONTENT

  <table id="drawListTabularData" class="content table-border" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
      <tr class="permissionTableMainHeader">
         $debugHeadline
        <th $textAlign nowrap>Draw #</th>
        <th $textAlign nowrap>Through Date</th>
        <th $textAlign nowrap>Status</th>
        <th $textAlign nowrap>PCSV value</th>
        <th $textAlign nowrap>Approved CO's</th>
        <th $textAlign nowrap>Total Sch.Val</th>
        <th $textAlign nowrap>Billed To Date</th>
        <th $textAlign nowrap>% Comp</th>
        <th $textAlign nowrap>Curr. App</th>
        <th $textAlign nowrap>Curr. Ret</th>
        <th $textAlign nowrap>Total Ret</th>
        $actionThHtml
      </tr>
    </thead>
    <tbody class="">
       $drawListTableBody
    </tbody>
  </table>

END_HTML_CONTENT;

  return $htmlContent;
}

//renders draw status dropdown
function renderDrawStatusHtml($database){
    $drawStatusList = DrawStatus::getDrawsStatus($database);
    $select = <<<END_DRAW_STATUS
    <select id="draw_status_id" onchange="filterDraw(this)" style="margin-bottom:15px">
    <option value="" selected="">All</option>
END_DRAW_STATUS;
    foreach ($drawStatusList as $key => $value) {
      $statusId = $value['id'];
      $statusValue = $value['status'];
      $select .=<<<END_DRAW_STATUS_OPTION
        <option value="$statusId">$statusValue</option>
END_DRAW_STATUS_OPTION;
    }
    return $select;
}

function renderCreateDrawHtml($database,$projectId,$applicationId){
  $permissions = Zend_Registry::get('permissions');
  $userCanViewDraws = checkPermissionForAllModuleAndRole($database,'view_draws');
  $userCanEditDraws = checkPermissionForAllModuleAndRole($database,'edit_draws');
  $userCanPostDraws = checkPermissionForAllModuleAndRole($database,'post_draws');

  $session = Zend_Registry::get('session');
  $userRole = $session->getUserRole();
  $debugMode = $session->getDebugMode();
  /* get recent draw count */
  $getRecentDrawId = Draws::getDrawRecentCount($database, $projectId, $applicationId);
  $drawData = Draws::getDrawData($database,$projectId,$applicationId);
  $project = Project::findProjectByIdExtended($database, $projectId);
  $drawTemplateId = $project->draw_template_id;
  if(empty($drawTemplateId)){
    $drawTemplateId = 0;
  }

  if(!empty($drawData)){
    $drawId = $drawData['id'];
    $drawStatus = $drawData['status'];
    $applicationNumber = $drawData['application_number'];
    $isDrawDisbaled = false;
    $disabled = '';
    if($drawStatus == 2){
      $isDrawDisbaled = true;
      $disabled = 'disabled="disabled"';
    }
    $throughDate = date('m/d/Y',strtotime($drawData['through_date']));
    $invoiceDate = date('m/d/Y',strtotime($drawData['invoice_date']));

    $arrCountOfDraftDraw = Draws::findDraftDrawCountUsingDrawId($database, $projectId, $drawId);
    $getCountOfDraftDraw = $arrCountOfDraftDraw['rowCount'];
    /* check the draw if posted */
    $readOnlyClass = '';
    $readOnlyClassPostDraw = '';
    $onClickFunction = "onclick='saveDrawAsDraft($drawId)'";
    if($drawData['status'] == 2){
      $readOnlyClassPostDraw = 'disabled="disabled"';
      $onClickFunction = "onclick='saveDraftAsFromPostDrawConfirmation($drawId)'";
      if($getCountOfDraftDraw > 0){
        $onClickFunction = "onclick='saveDrawAsDraft($drawId)'";
      }

      if($getRecentDrawId == $drawId){
        $readOnlyClass = '';
      } else {
        $readOnlyClass = 'disabled="disabled"';
      }
    } else {
      $readOnlyClass = '';
    }

    $saveButtonsHtml = <<<END_BUTTON_HTML_CONTENT
      <li class="" style="margin: 5px 0px 0px 5px;"><br/><input type="button" $readOnlyClassPostDraw value="Save as draft" $onClickFunction></li>
END_BUTTON_HTML_CONTENT;
 $allocationCount = DrawItems::checkReallocationExists($database,$drawId);
    if($allocationCount >0)
    {
      $alloclick = "disableReallocation($drawId)";
      $alloval ="Hide Reallocations";
    }else
    {
      $alloclick = "enableReallocation($drawId)";
       $alloval ="Add Reallocations";
    }
    if($userCanPostDraws || $userRole == "global_admin"){
      $saveButtonsHtml .= <<<END_BUTTON_HTML_CONTENT
      <li class="" style="margin: 5px 0px 0px 5px;"><br/>(OR)</li>
      <li class="" style="margin: 5px 0px 0px 5px;"><br/><input $readOnlyClassPostDraw type="button" value="Post Draw" onclick='postDraw($drawId)'></li>
      <li class="" style="margin: 5px 0px 0px 5px;"><br/><input $readOnlyClassPostDraw type="button" value="$alloval" id="reallocation-li" onclick='$alloclick'></li>
      <li style="margin: 5px 0px 0px 5px;"><br/><input $readOnlyClassPostDraw type="button" value="Commit Reallocation" id="reallocation-li" onclick="postReallocation($drawId)"></li>
END_BUTTON_HTML_CONTENT;
    }
    $throughDateHtml = <<<END_HTML_CONTENT
        <div class="datepicker_style_custom">
          <input id="draw_items--through_date--$drawId" $disabled class="through_datepicker drawDateCls" type="text" placeholder="Pick a Date" onchange="updateDrawDate(this, '');" value="$throughDate"><img class="through_datepicker dateDivSecCalIcon" width="13" src="./images/cal.png">
        </div>
END_HTML_CONTENT;
    $invoiceDateHtml = <<<END_HTML_CONTENT
        <div class="datepicker_style_custom">
          <input id="draw_items--invoice_date--$drawId" $disabled class="through_datepicker drawDateCls" type="text" placeholder="Pick a Date" onchange="updateInvoiceDate(this, '');" value="$invoiceDate"><img class="through_datepicker invoicedateDivSecCalIcon" width="13" src="./images/cal.png">
        </div>
END_HTML_CONTENT;
    /* Get Action Types*/
    $loadarrDrawActionOptions = new Input();
    $loadarrDrawActionOptions->forceLoadFlag = true;
    $loadarrDrawActionOptions->arrOrderByAttributes = array(
      'dat.`id`' => 'ASC'
    );
    $arrDrawActionTypes = DrawActionTypes::loadAllDrawActionTypes($database, $loadarrDrawActionOptions);
    $actionTypeHtmlOption = "";
    foreach($arrDrawActionTypes as $drawActionTypeId => $actionType) {
      $draw_action_type_id = $actionType->draw_action_type_id;
      $xlsx_download = $actionType->xlsx_download;
      $pdf_download = $actionType->pdf_download;
      $option_name = $actionType->action_name;
      $action_option = $actionType->action_option;
      $actionTypeValue = array();
      $actionTypeValue['draw_action_type_id'] = $draw_action_type_id;
      $actionTypeValue['action_option'] = $action_option;
      $actionTypeValue['pdf_download'] = $pdf_download;
      $actionTypeValue['xlsx_download'] = $xlsx_download;
      $actionTypeValueJson = implode('--', $actionTypeValue);
      $actionTypeHtmlOption .= <<<ACTIONTYPEHTML
      <option value='$actionTypeValueJson'>$option_name</option>
ACTIONTYPEHTML;
      //  check the condition if only continue else return to the loop
      if($action_option != 'Y') {
        continue;
      }
    }

    if($debugMode){
      $drawIdHtml = <<<END_DRAW_ID_DEBUG_HTML
          <li class="textAlignCenter">
            <div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
              <span>DRAW ID</span><br/> <span class="textColorBlue">$drawId</span>
            </div>
          </li>
END_DRAW_ID_DEBUG_HTML;
    }else{
      $drawIdHtml = '';
    }


    $applicationNumberHtml = <<<END_APPLICATION_NUMBER
    <div class="">
      <ul class="griddetail-deltalane griddetail-deltaactions">
        <li class="float-none m-b-20"><input type="button" value="Back to draws" onclick="gotoDrawList()"></li>
        $drawIdHtml
        <li class="textAlignCenter"><span>Application Number:</span><br/> <span class="textColorBlue">$applicationNumber</span></li>
        <li><span class="">Through Date:<br/></span> $throughDateHtml</li>
        <li><span class="">Invoice Date:<br/></span> $invoiceDateHtml</li>
        <li style="margin-left: 5px; margin-right: 5px;">
          <span>Draw Actions<br/></span>
          <table>
            <tr>
              <td>
                <select id="manage_draw--select_action_type" onchange="changeSubOptionVal(this,$drawTemplateId)">
                 <option value="0">Select Type</option>
                 $actionTypeHtmlOption
                </select>
              </td>
              <td>
                <select id="manage_draw--select_action_type_option" onchange="onchangeSubOrderChangeValue()" style="width:101px;">
                 <option value="">Select Option</option>
                </select>
              </td>
              <td id="multiselectoption" style="display:none;width:150px;">
              
                <select id="export_option" multiple="true" style="width: 100%; height: 125px;">
                  <option value="">Select Export Option</option>
                  <option value="general_condition_summary" >General Conditions Summary Only</option>
                  <option value="narrative_column">Narrative Column</option>
                  <option value="cost_code_alias">Cost Code Aliases</option>                  
                </select>
              </td>
              <td>
                <a onclick="clickToGenerateDrawPdfBasedActionType()"><img style="display:none;" class="downloadImg pdfDownload bs-tooltip" title="PDF Download" src="./images/icons/pdf-download.png"></a>
              </td>
              <td>
                <a onclick="generateDrawAsExcel($drawId,$applicationNumber,0)"><img style="display:none;" class="downloadImg xlsxDownload bs-tooltip" title="XLSX Download" src="./images/icons/xlsx-download.png"></a>
              </td>
            </tr>
          </table>
        </li>
        $saveButtonsHtml
      </ul>
    </div>
END_APPLICATION_NUMBER;
    $textAlign = 'align="center"';
    $budgetGridHtml = renderBudgetGridHtml($database,$projectId,$drawId,$applicationNumber,$isDrawDisbaled);
    $budgetGridBody = $budgetGridHtml['budgetListTableBody'];
    $getTabIndex = $budgetGridHtml['tabIndex'];
    $totalBudgetScheduledValue = $budgetGridHtml['totalBudgetScheduledValue'];
    $totalBudgetCompletionPercentage = $budgetGridHtml['totalBudgetCompletionPercentage'];
    $totalBudgetPreviousApp = $budgetGridHtml['totalBudgetPreviousApp'];
    $totalBudgetCurrentApp = $budgetGridHtml['totalBudgetCurrentApp'];
    $totalBudgetCurrentRetainage = $budgetGridHtml['totalBudgetCurrentRetainage'];
    $totalBudgetPreviousRetainage = $budgetGridHtml['totalBudgetPreviousRetainage'];
    $totalBudgetCompletedApp = $budgetGridHtml['totalBudgetCompletedApp'];
    $totalBudgetRetainage = $budgetGridHtml['totalBudgetRetainage'];
    $totalBudgetRealocation = $budgetGridHtml['totalBudgetRealocation'];

    $totalBudgetScheduledValueFormatted = $totalBudgetScheduledValue ? Format::formatCurrency($totalBudgetScheduledValue) : '';
    $totalBudgetCompletionPercentageFormatted = $totalBudgetCompletionPercentage ? numberFormat($totalBudgetCompletionPercentage) : '';
    $totalBudgetPreviousAppFormatted = $totalBudgetPreviousApp ? Format::formatCurrency($totalBudgetPreviousApp) : '';
    $totalBudgetCurrentAppFormatted = $totalBudgetCurrentApp ? Format::formatCurrency($totalBudgetCurrentApp) : '';
    $totalBudgetPreviousRetainageFormatted = $totalBudgetPreviousRetainage ? Format::formatCurrency($totalBudgetPreviousRetainage) : '';
    $totalBudgetCurrentRetainageFormatted = $totalBudgetCurrentRetainage ? Format::formatCurrency($totalBudgetCurrentRetainage) : '';
    $totalBudgetCompletedAppFormatted = $totalBudgetCompletedApp ? Format::formatCurrency($totalBudgetCompletedApp) : '';
    $totalBudgetRetainageFormatted = $totalBudgetRetainage ? Format::formatCurrency($totalBudgetRetainage) : '';
    $totalBudgetRealocationFormatted = $totalBudgetRealocation ? Format::formatCurrency($totalBudgetRealocation) : '$0.00';
    $totalBudgetRealocationhidden = $totalBudgetRealocation ? $totalBudgetRealocation : '0.00';

    if($debugMode){
      $colSpan = 5;
    }else{
      $colSpan = 1;
    }
    $allocationCount = DrawItems::checkReallocationExists($database,$drawId);
    if($allocationCount >0)
    {
      $allostyle = "display:revert";
    }else
    {
      $allostyle = "display:none";
    }
    $totalBudgetScheduledValueClass = $totalBudgetScheduledValue < 0 ? 'red' : '';
    $totalBudgetCompletionPercentageClass = $totalBudgetCompletionPercentage < 0 ? 'red' : '';
    $totalBudgetPreviousAppClass = $totalBudgetPreviousApp < 0 ? 'red' : '';
    $totalBudgetCurrentAppClass = $totalBudgetCurrentApp < 0 ? 'red' : '';
    $totalBudgetCurrentRetainageClass = $totalBudgetCurrentRetainage < 0 ? 'red' : '';
    $totalBudgetPreviousRetainageClass = $totalBudgetPreviousRetainage < 0 ? 'red' : '';
    $totalBudgetCompletedAppClass = $totalBudgetCompletedApp < 0 ? 'red' : '';
    $totalBudgetRetainageClass = $totalBudgetRetainage < 0 ? 'red' : '';
    $totalBudgetRealocationClass = $totalBudgetRealocation < 0 ? 'red' : '';
    $budgetTotalHtml = "<tr class='purStyle lightgray-bg'>
                        <td colspan='$colSpan'></td>
                        <td align='right'><b>Total</b></td>
                        <td align='right'><b><div class='$totalBudgetScheduledValueClass'>$totalBudgetScheduledValueFormatted</div></b></td>
                         <td align='right' class='realocate' style='$allostyle'>
                          <input type='hidden' id='reallototal' value='$totalBudgetRealocationhidden'>
                          <b><div class='$totalBudgetRealocationClass'>$totalBudgetRealocationFormatted</div></b></td>
                         <td align='right' class='realocate' style='$allostyle'></td>
                        <td align='right'><b><div class='$totalBudgetPreviousAppClass'>$totalBudgetPreviousAppFormatted</div></b></td>
                        <td align='right'><b><div class='$totalBudgetCompletionPercentageClass'>$totalBudgetCompletionPercentageFormatted</div></b></td>
                        <td align='right'><b><div class='$totalBudgetCurrentAppClass'>$totalBudgetCurrentAppFormatted</div></b></td>
                        <td align='center'></td>
                        <td align='right'><b><div class='$totalBudgetCurrentRetainageClass'>$totalBudgetCurrentRetainageFormatted</div></b></td>
                        <td align='right'><b><div class='$totalBudgetPreviousRetainageClass'>$totalBudgetPreviousRetainageFormatted</div></b></td>
                        <td align='right'><b><div class='$totalBudgetCompletedAppClass'>$totalBudgetCompletedAppFormatted</div></b></td>
                        <td align='right'><b><div class='$totalBudgetRetainageClass'>$totalBudgetRetainageFormatted</div></b></td>
                        <td colspan='1'></td>
                      </tr>";

    $changeOrderGridHtml = renderChangeOrderGridHtml($database,$projectId,$drawId,$applicationNumber,$isDrawDisbaled, $getTabIndex);
    $orderTableBody = $changeOrderGridHtml['orderTableBody'];

    $totalApprovedCORValue = $changeOrderGridHtml['totalApprovedCORValue'];
    $totalCoCompletedPercentage = $changeOrderGridHtml['totalCoCompletedPercentage'];
    $totalCoPreviousApp = $changeOrderGridHtml['totalCoPreviousApp'];
    $totalCoCurrentApp = $changeOrderGridHtml['totalCoCurrentApp'];
    $totalCoCurrentRetainage = $changeOrderGridHtml['totalCoCurrentRetainage'];
    $totalCoPreviousRetainage = $changeOrderGridHtml['totalCoPreviousRetainage'];
    $totalCoCompletedApp = $changeOrderGridHtml['totalCoCompletedApp'];
    $totalCoRetainage = $changeOrderGridHtml['totalCoRetainage'];
    $totalCORealloction = $changeOrderGridHtml['totalCORealloction'];

    $totalApprovedCORValueFormatted = $totalApprovedCORValue ? Format::formatCurrency($totalApprovedCORValue) : '';
    $totalCoCompletedPercentageFormatted = $totalCoCompletedPercentage ? numberFormat($totalCoCompletedPercentage) : '';
    $totalCoPreviousAppFormatted = $totalCoPreviousApp ? Format::formatCurrency($totalCoPreviousApp) : '';
    $totalCoCurrentAppFormatted = $totalCoCurrentApp ? Format::formatCurrency($totalCoCurrentApp) : '';
    $totalCoPreviousRetainageFormatted = $totalCoPreviousRetainage ? Format::formatCurrency($totalCoPreviousRetainage) : '';
    $totalCoCurrentRetainageFormatted = $totalCoCurrentRetainage ? Format::formatCurrency($totalCoCurrentRetainage) : '';
    $totalCoCompletedAppFormatted = $totalCoCompletedApp ? Format::formatCurrency($totalCoCompletedApp) : '';
    $totalCoRetainageFormatted = $totalCoRetainage ? Format::formatCurrency($totalCoRetainage) : '';
    $totalCoReallocationFormatted = $totalCORealloction ? Format::formatCurrency($totalCORealloction) : '$0.00';

    $totalApprovedCORValueClass = $totalApprovedCORValue < 0 ? 'red' : '';
    $totalCoCompletedPercentageClass = $totalCoCompletedPercentage < 0 ? 'red' : '';
    $totalCoPreviousAppClass = $totalCoPreviousApp < 0 ? 'red' : '';
    $totalCoCurrentAppClass = $totalCoCurrentApp < 0 ? 'red' : '';
    $totalCoCurrentRetainageClass = $totalCoCurrentRetainage < 0 ? 'red' : '';
    $totalCoPreviousRetainageClass = $totalCoPreviousRetainage < 0 ? 'red' : '';
    $totalCoCompletedAppClass = $totalCoCompletedApp < 0 ? 'red' : '';
    $totalCoRetainageClass = $totalCoRetainage < 0 ? 'red' : '';
    $totalCORealloctionClass = $totalCORealloction < 0 ? 'red' : '';
    $changeOrderTotalHtml =   "<tr class='purStyle lightgray-bg'>
                              <td colspan='$colSpan'></td>
                              <td align='right'><b>Total</b></td>
                              <td align='right'><b><div class='$totalApprovedCORValueClass'>$totalApprovedCORValueFormatted</div></b></td>
                               <td align='right' class='realocate' style='$allostyle'><b><div class='$totalCORealloctionClass'></div></b></td>
                               <td align='right' class='realocate' style='$allostyle'></td>
                              <td align='right'><b><div class='$totalCoPreviousAppClass'>$totalCoPreviousAppFormatted</div></b></td>
                              <td align='right'><b><div class='$totalCoCompletedPercentageClass'>$totalCoCompletedPercentageFormatted</div></b></td>
                              <td align='right'><b><div class='$totalCoCurrentAppClass'>$totalCoCurrentAppFormatted</div></b></td>
                              <td align='center'></td>
                              <!--<td align='center'></td>-->
                              <td align='right'><b><div class='$totalCoCurrentRetainageClass'>$totalCoCurrentRetainageFormatted</div></b></td>
                              <td align='right'><b><div class='$totalCoPreviousRetainageClass'>$totalCoPreviousRetainageFormatted</div></b></td>
                              <td align='right'><b><div class='$totalCoCompletedAppClass'>$totalCoCompletedAppFormatted</div></b></td>
                              <td align='right'><b><div class='$totalCoRetainageClass'>$totalCoRetainageFormatted</div></b></td>
                              <td colspan='1'></td>
                            </tr>";
    $totalProjectScheduledValue = $totalBudgetScheduledValue+$totalApprovedCORValue;
    $totalProjectReallocationValue = $totalBudgetRealocation+$totalCORealloction;
    $totalProjectPreviousApp = $totalBudgetPreviousApp+$totalCoPreviousApp;
    $totalProjectCurrentApp = $totalBudgetCurrentApp+$totalCoCurrentApp;
    $totalProjectCurrentRetainage = $totalBudgetCurrentRetainage+$totalCoCurrentRetainage;
    $totalProjectPreviousRetainage = $totalBudgetPreviousRetainage+$totalCoPreviousRetainage;
    $totalProjectCompletedApp = $totalBudgetCompletedApp+$totalCoCompletedApp;
    $totalProjectRetainage = $totalBudgetRetainage+$totalCoRetainage;
    $totalProjectCompletionPercentage = ($totalProjectCompletedApp/$totalProjectScheduledValue)*100;


    $totalProjectScheduledValueFormatted = $totalProjectScheduledValue ? Format::formatCurrency($totalProjectScheduledValue) : '';
    $totalProjectReallocationValueFormatted = $totalProjectReallocationValue ? Format::formatCurrency($totalProjectReallocationValue) : '$0.00'; 
    // total realoocation value i hidden field
     $totalProjectReallocationValuehidden = $totalProjectReallocationValue ? $totalProjectReallocationValue : '0.00';     
    $totalProjectPreviousAppFormatted = $totalProjectPreviousApp ? Format::formatCurrency($totalProjectPreviousApp) : '';
    $totalProjectCurrentAppFormatted = $totalProjectCurrentApp ? Format::formatCurrency($totalProjectCurrentApp) : '';
    $totalProjectCurrentRetainageFormatted = $totalProjectCurrentRetainage ? Format::formatCurrency($totalProjectCurrentRetainage) : '';
    $totalProjectPreviousRetainageFormatted = $totalProjectPreviousRetainage ? Format::formatCurrency($totalProjectPreviousRetainage) : '';
    $totalProjectCompletedAppFormatted = $totalProjectCompletedApp ? Format::formatCurrency($totalProjectCompletedApp) : '';
    $totalProjectRetainageFormatted = $totalProjectRetainage ? Format::formatCurrency($totalProjectRetainage) : '';
    $totalProjectCompletionPercentageFormatted = $totalProjectCompletionPercentage ? numberFormat($totalProjectCompletionPercentage) : '';


      $totalProjectScheduledValueClass = $totalProjectScheduledValue < 0 ? 'red' : '';
      $totalProjectReallocationValueClass = $totalProjectReallocationValue == 0 ? '' : 'red';
      $totalProjectCompletionPercentageClass = $totalProjectCompletionPercentage < 0 ? 'red' : '';
      $totalProjectPreviousAppClass = $totalProjectPreviousApp < 0 ? 'red' : '';
      $totalProjectCurrentAppClass = $totalProjectCurrentApp < 0 ? 'red' : '';
      $totalProjectCurrentRetainageClass = $totalProjectCurrentRetainage < 0 ? 'red' : '';
      $totalProjectPreviousRetainageClass = $totalProjectPreviousRetainage < 0 ? 'red' : '';
      $totalProjectCompletedAppClass = $totalProjectCompletedApp < 0 ? 'red' : '';
      $totalProjectRetainageClass = $totalProjectRetainage < 0 ? 'red' : '';

      $projectTotalHtml = "<tr class='purStyle lightgray-bg'>
                            <td colspan='$colSpan'></td>
                            <td align='right'><b>Overall Total</b></td>
                            <td align='right'><b><div class='$totalProjectScheduledValueClass'>$totalProjectScheduledValueFormatted</div></b></td>
                             <td align='right' class='realocate' style='$allostyle'><b><div class='$totalProjectReallocationValueClass'>$totalProjectReallocationValueFormatted</div></b></td>
                             <td align='right' class='realocate' style='$allostyle'></td>
                            <td align='right'><b><div class='$totalProjectPreviousAppClass'>$totalProjectPreviousAppFormatted</div></b></td>
                            <td align='right'><b><div class='$totalProjectCompletionPercentageClass'>$totalProjectCompletionPercentageFormatted</div></b></td>
                            <td align='right'><b><div class='$totalProjectCurrentAppClass'>$totalProjectCurrentAppFormatted</div></b></td>
                            <td align='center'></td>
                            <td align='right'><b><div class='$totalProjectCurrentRetainageClass'>$totalProjectCurrentRetainageFormatted</div></b></td>
                            <td align='right'><b><div class='$totalProjectPreviousRetainageClass'>$totalProjectPreviousRetainageFormatted</div></b></td>
                            <td align='right'><b><div class='$totalProjectCompletedAppClass'>$totalProjectCompletedAppFormatted</div></b></td>
                            <td align='right'><b><div class='$totalProjectRetainageClass'>$totalProjectRetainageFormatted</div></b></td>
                            <td colspan='1'></td>
                        </tr>";

      $createDrawGridHtml = '';
      $createDrawGridHtml .= $budgetGridBody;
      $createDrawGridHtml .= $budgetTotalHtml;
      $createDrawGridHtml .= $orderTableBody;
      if($orderTableBody){
        $createDrawGridHtml .= $changeOrderTotalHtml;
        $createDrawGridHtml .= $projectTotalHtml;
      }

      $htmlContent = $applicationNumberHtml;
      if ($debugMode) {
        $debugHeadline =  '<th>GBLI<br>ID</th>
                          <th>CCD<br>ID</th>
                          <th>CODE<br>ID</th>
                          <th style="min-width:60px">DRAW ITEM ID</th>';
      } else {
        $debugHeadline = '';
      }
      
    $htmlContent .= <<<END_HTML_CONTENT

  <table id="createDrawTabularData" class="content c-order notSortable" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
      <tr class="permissionTableMainHeader">
        $debugHeadline
        <th>Cost Code</th>
        <th>Cost Code Description</th>
        <th>Scheduled Value</th>
        <th class="realocate" style='$allostyle'>Reallocations</th>
        <th class="realocate" style='$allostyle'>Notes</th>
        <th style="min-width: 85px;">Previous App</th>
        <th> % Comp</th>
        <th>Current App</th>
        <th>Retention Rate</th>
        <th>Current Retention</th>
        <th>Previous Retainage</th>
        <th>Total Completed(Prev + Curr App)</th>
        <th>Total Retention</th>
        <th>Narrative</th>
      </tr>
    </thead>
    <tbody class="">
       $createDrawGridHtml
    </tbody>
  </table>
END_HTML_CONTENT;

    return $htmlContent;
  }else{
    header("Location:modules-draw-list.php");
    exit;
  }
}
/**
 * budget grid html
 */
function renderBudgetGridHtml($database,$projectId, $drawId, $applicationNumber, $isDrawDisbaled){
  $session = Zend_Registry::get('session');
  $user_company_id = $session->getUserCompanyId();
  $debugMode = $session->getDebugMode();
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $budgetList = DrawItems::getBudgetDrawItems($database,$drawId,'',$cor_type);
  $corType = ($cor_type == 2) ? 'A' : 'B';
  $budgetListTableBody = '';
  $totalBudgetScheduledValue = 0;
  $totalBudgetPreviousApp = 0;
  $totalBudgetCurrentApp = 0;
  $totalBudgetRealocation = 0;
  $totalBudgetCurrentRetainage = 0;
  $totalBudgetPreviousRetainage = 0;
  $totalBudgetCompletedApp = 0;
  $totalBudgetRetainage = 0;
  $totalBudgetCompletionPercentage = 0;
  $tab1 = 2001;
  $tab2 = 2002;
  $tab3 = 2003;
  $tab4 = 2004;
  $tab5 = 2005;
  $tab6 = 1999;
  $tab7 = 2000;
  //cost code divider
  $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
  foreach ($budgetList as $key => $value) {
    $drawItemId = $value['id'];
    $budgetLineItemId = $value['gc_budget_line_item_id'];
    $costCodeDivision = $value['division_number'];
    $costCodeDivisionId = $value['cost_code_division_id'];
    $costCodeId = $value['cost_code_id'];
    $costCode = $value['cost_code'];
    $costCodeDesc = $value['cost_code_description']; 
    $is_realocation = $value['is_realocation'];   
    $renotes = $isDrawDisbaled ? $value['renotes'] : UniversalService::br2nl($value['renotes']) ;
    $realocationValue = $value['realocation'];
    $totalBudgetRealocation = round(($totalBudgetRealocation+$realocationValue),2);
    //To reduce reallocation from Schdule_value
    $scheduledValue = $value['scheduled_value'];
    if ($is_realocation) {
      $scheduledValue = $value['scheduled_value'] + $realocationValue;
    }
    $totalBudgetScheduledValue += $scheduledValue;
    $retainerRate = $value['retainer_rate'];
    $narrative = $value['narrative'];
    $currentApp = $value['current_app'];
    $totalBudgetCurrentApp += $currentApp;
    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$budgetLineItemId,'gc_budget_line_item_id',$drawItemId,$applicationNumber,$corType);
    $projectPreviousCompletion = DrawItems::getPreviousBudgetValues($database, $projectId,$budgetLineItemId,$drawItemId,$corType);
    $perviousCompletedPercent = $currentApp ? $value['completed_percent']:$projectPreviousCompletion['completed_percent'];
    if($perviousCompletedPercent==''){
      $perviousCompletedPercent='0.00';
    }
    $previousApp = $previousDrawValue['current_app'] ? $previousDrawValue['current_app'] : 0;
    $previousAppFormatted = !empty($previousApp) ? Format::formatCurrency($previousApp) : Format::formatCurrency(0.00);
    $totalBudgetPreviousApp += $previousDrawValue['current_app'];
    $totalCompletedApp = (float)$previousDrawValue['current_app'] + (float)$currentApp;
    $totalCompletedAppFormatted = $totalCompletedApp ? numberFormat($totalCompletedApp) : 0;
    $totalBudgetCompletedApp += $totalCompletedApp;
    // $totalRetainage = ((float)$totalCompletedApp*(float)$retainerRate)/100;
    $totalRetainage = ((float)$previousDrawValue['current_retainer_value']+(float)$value['current_retainer_value']);
    $totalRetainageFormatted = $totalRetainage ? Format::formatCurrency($totalRetainage) : '';
    $totalBudgetRetainage += $totalRetainage;
    $previousRetainerValue = $previousDrawValue['current_retainer_value'];
    $totalBudgetPreviousRetainage += $previousRetainerValue;
    $currentRetainerValue = $value['current_retainer_value'];
    $currentRetainerValueFormatted = !empty($currentRetainerValue) ? Format::formatCurrency($currentRetainerValue) : '';
    $realocationValueFormatted =!empty($realocationValue) ? Format::formatCurrency($realocationValue) : '';
    $previousRetainerValueFormatted = !empty($previousRetainerValue) ? Format::formatCurrency($previousRetainerValue) : '';
    $totalBudgetCurrentRetainage += $currentRetainerValue;
    $completedApp = !empty($totalCompletedAppFormatted) ? Format::formatCurrency($totalCompletedAppFormatted)  : '';
    $perviousCompletedPercentValue = $perviousCompletedPercent ? $perviousCompletedPercent : 0;
    $currentAppValue = $currentApp ? Format::formatCurrency($currentApp) : '';

  

    if($isDrawDisbaled){
      $completionPercentageInput = $perviousCompletedPercent;
      $currentAppInput = $currentAppValue;
      $narrativeInput = $narrative;
      $retainerRateInput = $retainerRate;
      $currentRetentionInput = $currentRetainerValueFormatted;
      $ReallocationInput = $realocationValueFormatted;
      $ReNotesInput = $renotes;
    }else{
      $completionPercentageClass = $perviousCompletedPercent < 0 ? "red" : '';
      $currentAppClass = $currentApp < 0 ? "red" : '';
      $currentRetClass = $currentRetainerValue < 0 ? "red" : '';
      $reallocateClass = $realocationValue < 0 ? "red" : '';

      $completionPercentageInput = <<<END_COMPLETION_PERCENTAGE_HTML
      <input tabIndex="$tab1" class="completed_percent draw_input_value $completionPercentageClass"  id="draw_items--gc_budget_line_item_id--completed_percent--$drawItemId" value="$perviousCompletedPercent" onchange="drawCostCodeValidation(this,$drawItemId,$budgetLineItemId,$drawId,$perviousCompletedPercentValue,'Completed Percentage');" style="text-align: right;">
END_COMPLETION_PERCENTAGE_HTML;

      $currentAppInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab2" class="current_app current_app_input_value $currentAppClass" id="draw_items--gc_budget_line_item_id--current_app--$drawItemId" value="$currentAppValue" onchange="drawCostCodeValidation(this,$drawItemId,$budgetLineItemId,$drawId,$previousApp,'Current App');" style="text-align: right;">
      <input type="hidden" id="pre-curt-app-value_$drawItemId" value="$currentAppValue">
END_CURRENT_APP_HTML;
      $narrativeInput = <<<END_NARRATIVE_HTML
      <textarea tabIndex="$tab5" class="scrollbar-design" id="draw_items--gc_budget_line_item_id--narrative--$drawItemId" onchange="updateDrawItem(this,$drawItemId,$budgetLineItemId,$drawId,'Narrative');" rows="2" style="width:180px;">$narrative</textarea>
END_NARRATIVE_HTML;
      $retainerRateInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab3" class="retainer_rate draw_input_value" id="draw_items--gc_budget_line_item_id--retainer_rate--$drawItemId" value="$retainerRate" onchange="drawCostCodeValidation(this,$drawItemId,$budgetLineItemId,$drawId,'','Retainer Rate');" style="text-align: right;width:80px;">
       <input type="hidden" id="pre-retention-rate_$drawItemId" value="$retainerRate">
END_CURRENT_APP_HTML;
 $currentRetentionInput = <<<END_CURRENT_RET_HTML
      <input tabIndex="$tab4" class="current_retention current_app_input_value  $currentRetClass" id="draw_items--gc_budget_line_item_id--current_retention--$drawItemId" value="$currentRetainerValueFormatted" onchange="drawCostCodeValidation(this,$drawItemId,$budgetLineItemId,$drawId,'','Current Retention');" style="text-align: right;width:80px;">
      <input type="hidden" id="pre-curt-retention-rate_$drawItemId" value="$currentRetainerValueFormatted">
END_CURRENT_RET_HTML;
//For rellocations
 $ReallocationInput = <<<END_CURRENT_RET_HTML
      <input type="hidden" id="old_realocation_val_$drawItemId" value="$realocationValue">
      <input tabIndex="$tab6" class="realocation reloact_input_value $reallocateClass" id="draw_items--gc_budget_line_item_id--realocation--$drawItemId" value="$realocationValue" onchange="drawCostCodeValidation(this,$drawItemId,$budgetLineItemId,$drawId,$is_realocation,'Reallocation');" style="text-align: right;width:80px;">

END_CURRENT_RET_HTML;
  $ReNotesInput = <<<END_CURRENT_RET_HTML
   <textarea tabIndex="$tab7" class="renotes" id="draw_items--gc_budget_line_item_id--renotes--$drawItemId" onchange="updateDrawItem(this,$drawItemId,$budgetLineItemId,$drawId,'Renotes');" rows="2" style="width:180px;">$renotes</textarea>
END_CURRENT_RET_HTML;
    }
    $primeScheduledValue = $scheduledValue ? Format::formatCurrency($scheduledValue) : '';

    $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items ui-sortable-handle" id="gc-budget-line-items_$drawItemId">
END_DRAW_TABLE_TBODY;
    if($debugMode){
      $html_gc_budget_line_item_id = (!empty($budgetLineItemId) ? $budgetLineItemId : '&nbsp;');
      $html_cost_code_division_id = (!empty($costCodeDivisionId) ? $costCodeDivisionId : '&nbsp;');
      $html_cost_code_id = (!empty($costCodeId) ? $costCodeId : '&nbsp;');
      $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
          <td>$html_gc_budget_line_item_id</td>
          <td>$html_cost_code_division_id</td>
          <td>$html_cost_code_id</td>
          <td>$drawItemId</td>
END_DRAW_TABLE_TBODY;
    }
    $currentAppClass = $currentApp < 0 ? "red" : '';
    $primeScheduledValueClass = $scheduledValue < 0 ? "red" : '';
    $currentRetainerValueClass = $currentRetainerValue < 0 ? "red" : '';
    $previousRetainerValueClass = $previousRetainerValue < 0 ? "red" : '';
    $totalCompletedAppClass = $totalCompletedAppFormatted < 0 ? "red" : '';
    $totalRetainageClass = $totalRetainage < 0 ? "red" : '';
    // breakDown Values html
    $breakDownHtml = renderBreakdownHtml($database, $projectId, $drawId, $drawItemId, $applicationNumber,$isDrawDisbaled );
    $costCodeData = $costCodeDivision.$costCodeDividerType.$costCode;
    $allocationCount = DrawItems::checkReallocationExists($database,$drawId);
    if($allocationCount >0)
    {
      $allostyle = "display:revert";
    }else
    {
      $allostyle = "display:none";
    }
    
    $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
      <td class="textAlignCenter" nowrap">$costCodeData</td>
      <td class="" nowrap>$costCodeDesc</td>
      <td class="textAlignRight" nowrap><input type="hidden" value="$scheduledValue" id="draw_items--gc_budget_line_item_id--scheduled_value--$drawItemId"><div class="$primeScheduledValueClass">$primeScheduledValue</div></td>
      <td class="realocate" style='$allostyle' nowrap>$ReallocationInput</td>      
      <td class="textAlignCenter realocate" style='$allostyle' nowrap>$ReNotesInput</td>
      <td class="textAlignRight" nowrap id="draw_items--gc_budget_line_item_id--previous_app--$drawItemId"><input type="hidden" value="$previousApp" id="draw_items--gc_budget_line_item_id--previous_app_val--$drawItemId">$previousAppFormatted</td>
      <td class="textAlignRight" nowrap>$completionPercentageInput</td>
      <td class="textAlignRight" nowrap><div class="$currentAppClass">$currentAppInput</deiv></td>
      <td class="textAlignRight" nowrap>$retainerRateInput</td>
      <!--<td class="" nowrap>$breakDownHtml</td>-->
      <td class="textAlignRight" nowrap id="draw_items--gc_budget_line_item_id--current_retainer_value--$drawItemId">
        <div class="$currentRetainerValueClass">$currentRetentionInput</div>
      </td>
      <td class="textAlignRight" nowrap><input type="hidden" value="$previousRetainerValue" id="draw_items--gc_budget_line_item_id--previous_retainer_value--$drawItemId"><div class="$previousRetainerValueClass">$previousRetainerValueFormatted</div></td>
      <td class="textAlignRight" nowrap id="draw_items--gc_budget_line_item_id--total_app_value--$drawItemId">
        <div class="$totalCompletedAppClass">$completedApp</div>
      </td>
      <td class="textAlignRight" nowrap id="draw_items--gc_budget_line_item_id--total_retainer_value--$drawItemId">
        <div class="$totalRetainageClass">$totalRetainageFormatted</div>
      </td>
      <td class="textAlignCenter" nowrap>$narrativeInput</td>
    </tr>
END_DRAW_TABLE_TBODY;
$tab1 = $tab1+7;
$tab2 = $tab2+7;
$tab3 = $tab3+7;
$tab4 = $tab4+7;
$tab5 = $tab5+7;
$tab6 = $tab6+7;
$tab7 = $tab7+7;
  }
  $totalBudgetCompletionPercentage = ($totalBudgetCompletedApp/$totalBudgetScheduledValue)*100;
  $returnArr['totalBudgetScheduledValue'] = $totalBudgetScheduledValue;
  $returnArr['totalBudgetCompletionPercentage'] = $totalBudgetCompletionPercentage;
  $returnArr['totalBudgetPreviousApp'] = $totalBudgetPreviousApp;
  $returnArr['totalBudgetCurrentApp'] = $totalBudgetCurrentApp;
  $returnArr['totalBudgetCurrentRetainage'] = $totalBudgetCurrentRetainage;
  $returnArr['totalBudgetPreviousRetainage'] = $totalBudgetPreviousRetainage;
  $returnArr['totalBudgetCompletedApp'] = $totalBudgetCompletedApp;
  $returnArr['totalBudgetRetainage'] = $totalBudgetRetainage;
  $returnArr['totalBudgetRetentionInvoice'] = $totalBudgetRetainage;
  $returnArr['budgetListTableBody'] = $budgetListTableBody;
  $returnArr['tabIndex'] = $tab4;
  $returnArr['totalBudgetRealocation'] = $totalBudgetRealocation;
  return $returnArr;
}
/**
 * change order grid html
 */
function renderChangeOrderGridHtml($database,$projectId,$drawId,$applicationNumber,$isDrawDisbaled, $getTabIndex=1){
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $changeOrderRequests = DrawItems::getChangeOrderDrawItems($database,$drawId,'',$cor_type);
  $session = Zend_Registry::get('session');
  $corType = ($cor_type == 2) ? 'A' : 'B';
  $debugMode = $session->getDebugMode();
  $changeOrderListTableBody = '';
  $orderTableHeader = '';
  $orderTableBody = '';
  $totalApprovedCORValue = 0;
  $totalCoPreviousApp = 0;
  $totalCoCurrentApp = 0;
  $totalCoCurrentRetainage = 0;
  $totalCoPreviousRetainage = 0;
  $totalCoCompletedApp = 0;
  $totalCoCompletedPercentage = 0;
  $totalCORrealocationValue = 0;
  $totalCoRetainage = 0;
  $tab1 = $getTabIndex-3;
  $tab2 = $getTabIndex-2;
  $tab3 = $getTabIndex-1;
  $tab4 = $getTabIndex;
  $project = Project::findProjectByIdExtended($database, $projectId);    
  $OCODisplay = $project->COR_type;
  $changeOrderRequests = unique_array($changeOrderRequests,'change_order_id');
  foreach ($changeOrderRequests as $key => $changeOrderValue) {
    $drawItemId = $changeOrderValue['id'];
    $changeOrderId = $changeOrderValue['change_order_id'];
    $changeOrderTitle = $changeOrderValue['co_title'];
    $changeOrderPrefix = $changeOrderValue['co_type_prefix'];
    $realocationValue = $changeOrderValue['realocation'];
    $totalCORrealocationValue += $realocationValue;
    // To add or reduce the realoocation value
    $scheduledValue = $changeOrderValue['scheduled_value']+$realocationValue;
    $totalApprovedCORValue += $scheduledValue;
    $retainerRate  = $changeOrderValue['retainer_rate'];
    $narrative = $changeOrderValue['narrative'];
    $currentApp = $changeOrderValue['current_app'];
    $totalCoCurrentApp += $currentApp;
    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$changeOrderId,'change_order_id',$drawItemId,$applicationNumber,$corType);
    $projectPreviousCompletion = DrawItems::getPreviousCOValues($database, $projectId,$changeOrderId, $drawItemId);
    $perviousCompletedPercent = $currentApp ? $changeOrderValue['completed_percent']:$projectPreviousCompletion['completed_percent'];
    $previousApp = $previousDrawValue['current_app'] ? $previousDrawValue['current_app'] : 0;
    $previousAppFormatted = !empty($previousApp) ? Format::formatCurrency($previousApp) : '';
    $totalCoPreviousApp += $previousDrawValue['current_app'];
    $totalCompletedApp = (float)$previousDrawValue['current_app'] + (float)$currentApp;
    $totalCompletedAppFormatted = $totalCompletedApp ? numberFormat($totalCompletedApp) : 0;
    $totalCoCompletedApp += $totalCompletedApp;
    $totalRetainage = ((float)$previousDrawValue['current_retainer_value']+(float)$changeOrderValue['current_retainer_value']);
    $totalRetainageFormatted = $totalRetainage ? Format::formatCurrency($totalRetainage) : '';
    $totalCoRetainage += $totalRetainage;
    $previousRetainerValue = $previousDrawValue['current_retainer_value'];
    $totalCoPreviousRetainage += $previousRetainerValue;
    $completedApp = !empty($totalCompletedAppFormatted) ? Format::formatCurrency($totalCompletedAppFormatted) : '';
    $currentRetainerValue = $changeOrderValue['current_retainer_value'];
    $currentRetainerValueFormatted = !empty($currentRetainerValue) ? Format::formatCurrency($currentRetainerValue) : '';
    $previousRetainerValueFormatted = !empty($previousRetainerValue) ? Format::formatCurrency($previousRetainerValue) : '';
    $realocationValueFormatted = !empty($realocationValue) ? Format::formatCurrency($realocationValue) : '';
    
    $totalCoCurrentRetainage += $currentRetainerValue;
    $perviousCompletedPercentValue = $perviousCompletedPercent ? $perviousCompletedPercent : 0;
    $currentAppValue = $currentApp ? Format::formatCurrency($currentApp) : '';

    if($isDrawDisbaled){
      $completionPercentageInput = $perviousCompletedPercent;
      $currentAppInput = $currentAppValue;
      $narrativeInput = $narrative;
      $retainerRateInput = $retainerRate;
      $currentRetentionInput = $currentRetainerValueFormatted;
      $ReallocationInput = $realocationValueFormatted;
    }else{
      $completionPercentageClass = $perviousCompletedPercent < 0 ? "red" : '';
      $currentAppClass = $currentApp < 0 ? "red" : '';
      $currentRetClass = $currentRetainerValue < 0 ? "red" : '';
      $reallocateClass = $realocationValue < 0 ? "red" : '';

      $completionPercentageInput = <<<END_COMPLETION_PERCENTAGE_HTML
      <input tabIndex="$tab1" class="completed_percent draw_input_value $completionPercentageClass" id="draw_items--change_order_id--completed_percent--$drawItemId" value="$perviousCompletedPercent" onchange="drawCostCodeValidation(this,$drawItemId,$changeOrderId,$drawId,$perviousCompletedPercentValue,'Completed Percentage');" style="text-align: right;">
END_COMPLETION_PERCENTAGE_HTML;

      $currentAppInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab2" class="current_app current_app_input_value $currentAppClass" id="draw_items--change_order_id--current_app--$drawItemId" value="$currentAppValue" onchange="drawCostCodeValidation(this,$drawItemId,$changeOrderId,$drawId,$previousApp,'Current App');" style="text-align: right;">
      <input type="hidden" id="pre-curt-app-value_$drawItemId" value="$currentAppValue">
END_CURRENT_APP_HTML;
      $narrativeInput = <<<END_NARRATIVE_HTML
      <textarea tabIndex="$tab4" class="scrollbar-design" id="draw_items--change_order_id--narrative--$drawItemId" onchange="updateDrawItem(this,$drawItemId,$changeOrderId,$drawId,'Narrative');" rows="2" style="width:180px;">$narrative</textarea>
END_NARRATIVE_HTML;
      $retainerRateInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab3" class="draw_input_value retainer_rate" id="draw_items--change_order_id--retainer_rate--$drawItemId" value="$retainerRate" onchange="drawCostCodeValidation(this,$drawItemId,$changeOrderId,$drawId,'','Retainer Rate');" style="text-align: right;width:80px;">
      <input type="hidden" id="pre-retention-rate_$drawItemId" value="$retainerRate">
END_CURRENT_APP_HTML;
 $currentRetentionInput = <<<END_CURRENT_RET_HTML
      <input tabIndex="$tab4" class="current_retention current_retainer_input_value $currentRetClass" id="draw_items--change_order_id--current_retention--$drawItemId" value="$currentRetainerValueFormatted" onchange="drawCostCodeValidation(this,$drawItemId,$changeOrderId,$drawId,'','Current Retention');" style="text-align: right;width:80px;">
      <input type="hidden" id="pre-curt-retention-rate_$drawItemId" value="$currentRetainerValueFormatted">
END_CURRENT_RET_HTML;

//For rellocations
 $ReallocationInput = <<<END_CURRENT_RET_HTML
      <input tabIndex="$tab6" class="realocation reloact_input_value $reallocateClass" id="draw_items--gc_budget_line_item_id--realocation--$drawItemId" value="$realocationValue" onchange="updateDrawItem(this,$drawItemId,$changeOrderId,$drawId,'Reallocation');" style="text-align: right;width:80px;">
END_CURRENT_RET_HTML;
    }
    $primeScheduledValue = $scheduledValue ? '$'.$scheduledValue : '';

    $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="change_orders_row ui-sortable-handle" id="change-orders_$drawItemId">
END_DRAW_TABLE_TBODY;
    if($debugMode){
      $html_change_order_id = (!empty($changeOrderId) ? $changeOrderId : '&nbsp;');
      $html_cost_code_division_id = '&nbsp;';
      $html_cost_code_id = '&nbsp;';
      $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
          <td>$html_change_order_id</td>
          <td>$html_cost_code_division_id</td>
          <td>$html_cost_code_id</td>
          <td>$drawItemId</td>
END_DRAW_TABLE_TBODY;
    }
    $primeScheduledValueClass = $scheduledValue < 0 ? "red" : '';
    $currentRetainerValueClass = $currentRetainerValue < 0 ? "red" : '';
    $previousRetainerValueClass = $previousRetainerValue < 0 ? "red" : '';
    $totalCompletedAppClass = $totalCompletedAppFormatted < 0 ? "red" : '';
    $totalRetainageClass = $totalRetainage < 0 ? "red" : '';
    // breakDown Values html
    $breakDownHtml = renderBreakdownHtml($database, $projectId, $drawId, $drawItemId, $applicationNumber,$isDrawDisbaled);
     $allocationCount = DrawItems::checkReallocationExists($database,$drawId);
    if($allocationCount >0)
    {
      $allostyle = "display:revert";
    }else
    {
      $allostyle = "display:none";
    }

    
    $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
      <td class="textAlignCenter" nowrap>$changeOrderPrefix</td>
      <td class="" nowrap>$changeOrderTitle</td>
      <td class="textAlignRight" nowrap><input type="hidden" value="$scheduledValue" id="draw_items--change_order_id--scheduled_value--$drawItemId"><div class="$primeScheduledValueClass">$primeScheduledValue</div></td>
      <td class="realocate" style='$allostyle' nowrap></td>
      <td class="realocate" style='$allostyle' nowrap></td>
      <td class="textAlignRight" nowrap id="draw_items--change_order_id--previous_app--$drawItemId"><input type="hidden" value="$previousApp" id="draw_items--change_order_id--previous_app_val--$drawItemId">$previousAppFormatted</td>
      <td class="textAlignRight" nowrap>$completionPercentageInput</td>
      <td class="textAlignRight" nowrap>$currentAppInput</td>
      <td class="textAlignRight" nowrap>$retainerRateInput</td>
      <td class="textAlignRight" nowrap id="draw_items--change_order_id--current_retainer_value--$drawItemId">
       <div class="$currentRetainerValueClass">$currentRetentionInput</div>
      </td>
      <td class="textAlignRight" nowrap><input type="hidden" value="$previousRetainerValue" id="draw_items--change_order_id--previous_retainer_value--$drawItemId"><div class="$previousRetainerValueClass">$previousRetainerValueFormatted</div></td>
      <td class="textAlignRight" nowrap id="draw_items--change_order_id--total_app_value--$drawItemId">
       <div class="$totalCompletedAppClass">$completedApp</div>
      </td>
      <td class="textAlignRight" nowrap id="draw_items--change_order_id--total_retainer_value--$drawItemId">
       <div class="$totalRetainageClass">$totalRetainageFormatted</div>
      </td>
      <td class="textAlignCenter" nowrap>$narrativeInput</td>
    </tr>
END_DRAW_TABLE_TBODY;
$tab1 = $tab1+4;
$tab2 = $tab2+4;
$tab3 = $tab3+4;
$tab4 = $tab4+4;
  }
  if ($OCODisplay == 1) {
    if(count($changeOrderRequests)>0){
      if($debugMode){
        $titleColSpan = 18;
      }else{
        $titleColSpan = 14;
      }
      $orderTableHeader .= "<tr class='purStyle lightgray-bg'><td colspan='$titleColSpan'><b>Change Order Request</b></td></td></tr>";
      $orderTableBody .= $orderTableHeader;
    }
    $orderTableBody .= $changeOrderListTableBody;
  }

  $totalCoCompletedPercentage = ($totalCoCompletedApp/$totalApprovedCORValue)*100;
  $returnArr['totalApprovedCORValue'] = $totalApprovedCORValue;
  $returnArr['totalCoCompletedPercentage'] = $totalCoCompletedPercentage;
  $returnArr['totalCoPreviousApp'] = $totalCoPreviousApp;
  $returnArr['totalCoCurrentApp'] = $totalCoCurrentApp;
  $returnArr['totalCoCurrentRetainage'] = $totalCoCurrentRetainage;
  $returnArr['totalCoPreviousRetainage'] = $totalCoPreviousRetainage;
  $returnArr['totalCoCompletedApp'] = $totalCoCompletedApp;
  $returnArr['totalCoRetainage'] = $totalCoRetainage;
  $returnArr['totalCoRetentionInvoice'] = $totalCoRetainage;
  $returnArr['orderTableBody'] = $orderTableBody;
  $returnArr['totalCORealloction'] = $totalCORrealocationValue;
  return $returnArr;
}
/**
 * decimal values
 */
function numberFormat($number){
  if(!empty($number)){
    return number_format($number, 2);
  }else{
    return 0;
  }
}
/**
 * Get original contract value
 */

function getOriginal_contract_value($database,$projectId, $drawId, $applicationNumber, $showRetainer = false,$options='',$corDisplay=0,$cost_code_alias=''){
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $budgetList = DrawItems::getBudgetDrawItems($database,$drawId,$options,$cor_type);  
  $totalOriginalScheduledValue=0;
  foreach ($budgetList as $key => $value) {
    $drawItemId = $value['id'];  
    $originalScheduledValue = $value['prime_contract_scheduled_value'];
    $totalOriginalScheduledValue += $originalScheduledValue; 
  }
  $returnArr['totalOriginalScheduledValue'] = $totalOriginalScheduledValue;
  return $returnArr;
}

/**
 * Draw grid html for print pdf
 */
function renderDrawGridHtmlForPDF($database,$projectId, $drawId, $applicationNumber, $showRetainer = false,$options='',$corDisplay=0,$cost_code_alias=''){
  $allocationCount = DrawItems::checkReallocationExists($database,$drawId);
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $budgetList = DrawItems::getBudgetDrawItems($database,$drawId,$options,$cor_type);
  $session = Zend_Registry::get('session');
  $user_company_id = $session->getUserCompanyId();
  $project = Project::findProjectByIdExtended($database, $projectId);
  $alias_type = $project->alias_type;
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';

  //cost code divider
  $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
  $budgetListTableBody = '';
  $totalBudgetScheduledValue = $totalrevisedScheduledValue = $totalOriginalScheduledValue= $totalCoCurrentRetainage = $totalPrevRetainerValue = 0;
  $totalBudgetRealocation = $totalPreviousRealocationValue = $totalChangeOrderCostCodeVal = 0;
  $totalBudgetPreviousApp = 0;
  $totalBudgetCurrentApp = 0;
  $totalBudgetCompletedApp = 0;
  $totalBudgetRetainage = 0;
  $totalBudgetCompletionPercentage = 0;
  $general_cond_ScheduledValue = $general_cond_previousApp = $general_cond_currentApp = $general_cond_currentRetainerValue = $general_cond_totalCompletedApp = $general_cond_gc = $general_cond_cg = $general_cond_totalRetainage = $general_cond_previousRetainerValue = 0;
  foreach ($budgetList as $key => $value) {
    $drawItemId = $value['id'];
    $budgetLineItemId = $value['gc_budget_line_item_id'];
    $costCodeDivision = $value['division_number'];
    $costCode = $value['cost_code'];
    $cost_code_id = $value['cost_code_id'];
    $cost_code_divison_id = $value['cost_code_divison_id'];
    $costCodeDesc = $value['cost_code_description'];
    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_divison_id);
    $realocationValue = $value['realocation'];
    $totalBudgetRealocation = round(($totalBudgetRealocation+$realocationValue),2);
    $originalScheduledValue = $value['prime_contract_scheduled_value'];
    $scheduledValue = $value['scheduled_value'] + $realocationValue;
    // $scheduledValue = $value['scheduled_value'];
    $totalOriginalScheduledValue += $originalScheduledValue;
    $retainerRate  = $value['retainer_rate'];
    $narrative = $value['narrative'];
    $currentApp = $value['current_app'];
    $division_number_group_id = $value['division_number_group_id'];
    $totalBudgetCurrentApp += $currentApp;
    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$budgetLineItemId,'gc_budget_line_item_id',$drawItemId,$applicationNumber,$corType);
    $projectPreviousCompletion = DrawItems::getPreviousBudgetValues($database, $projectId,$budgetLineItemId,$drawItemId,$corType);
    // Sum of previous realocation value 
    $sumOfPreviousRealocationValue = DrawItems::getsumOfPreviousRealocationValue($database,$projectId,$drawId,$budgetLineItemId);
    $totalPreviousRealocationValue = round(($totalPreviousRealocationValue+$sumOfPreviousRealocationValue),2);
    // Sum of change order cost code value
    $changeOrderCostCodeVal = $scheduledValue - $originalScheduledValue - $realocationValue - $sumOfPreviousRealocationValue;
    $totalChangeOrderCostCodeVal += $changeOrderCostCodeVal;
    // Revised scheduled Value (scheduled value)
    // $revisedScheduledValue = $scheduledValue + $realocationValue;
    if ($corDisplay == 2) {
      $revisedScheduledValue = $scheduledValue;
      $totalrevisedScheduledValue += $revisedScheduledValue;
      $totalBudgetScheduledValue += $scheduledValue;
    }else{
      $revisedScheduledValue = $originalScheduledValue+$realocationValue+$sumOfPreviousRealocationValue;
      $totalrevisedScheduledValue += $revisedScheduledValue;
      $scheduledValue = $revisedScheduledValue;
      $totalBudgetScheduledValue += $scheduledValue;
    }

    $totalBudgetPreviousApp += $previousDrawValue['current_app'];
    $totalCompletedApp = (float)$previousDrawValue['current_app'] + (float)$currentApp;
    $totalBudgetCompletedApp += $totalCompletedApp;
    $totalRetainage = ((float)$previousDrawValue['current_retainer_value']+(float)$value['current_retainer_value']);

    $totalBudgetRetainage += $totalRetainage;
    $previousRetainerValue = $previousDrawValue['current_retainer_value'];
    $currentRetainerValue = $value['current_retainer_value'];
    $totalCoCurrentRetainage += $currentRetainerValue;
    $totalPrevRetainerValue += $previousRetainerValue;
    if ($currentRetainerValue && $currentRetainerValue !='0.00') {
     $currentRetainerValueFormatted = formatNegativeValues($currentRetainerValue);
    }else{
      $currentRetainerValueFormatted = '';
    }
    $previousRetainerValueFormatted = !empty($previousRetainerValue) ? formatNegativeValues($previousRetainerValue) : '';
    $sumOfPrevRealocationValFormatted = ($sumOfPreviousRealocationValue != '0.00') ? formatNegativeValues($sumOfPreviousRealocationValue) : '';
    $realocationValueFormatted = ($realocationValue != '0.00') ? formatNegativeValues($realocationValue) : '';
    $changeOrderCostCodeValFormatted = $changeOrderCostCodeVal ? formatNegativeValues($changeOrderCostCodeVal) : '';
    $revisedScheduledValueFormatted = formatNegativeValues($revisedScheduledValue);
    // totalcompleted / schedule values
    $gc = ($totalCompletedApp / $scheduledValue)*100;
    $cg = $scheduledValue - $totalCompletedApp;
    $totalCompletedApp_format = formatNegativeValues($totalCompletedApp);
    $gc_format = $gc ? formatNegativeValuesWithoutSymbol($gc, 2) : '';
    $cg_format = $cg ? formatNegativeValues($cg) : '';
    $primeScheduledValue = $scheduledValue ? formatNegativeValues($scheduledValue) : '';
    $primeOriginalScheduledValue = $originalScheduledValue ? formatNegativeValues($originalScheduledValue) : '';
    $currentApp_format =  $currentApp ? formatNegativeValues($currentApp) : '';
    $previousApp = $previousDrawValue['current_app'];
    $previousApp_format = formatNegativeValues($previousApp);
    $totalRetainageFormatted =  $totalRetainage ? formatNegativeValues($totalRetainage) : '';

    if(!empty($options) && ($options =='2' || $options =='3')  && !empty($division_number_group_id) && $division_number_group_id =='1'){ // General Conditions
      $general_cond_ScheduledValue += $scheduledValue;
      $general_cond_OriginalScheduledValue += $originalScheduledValue;
      $general_cond_previousApp += $previousApp;
      $general_cond_currentApp += $currentApp;
      $general_cond_currentRetainerValue += $currentRetainerValue;
      $general_cond_totalCompletedApp += $totalCompletedApp;
      $general_cond_totalRetainage += $totalRetainage;
      $general_cond_previousRetainerValue += $previousRetainerValue;
      $general_cond_sumOfPreviousRealocationValue += $sumOfPreviousRealocationValue;
      $general_cond_RealocationValue += $realocationValue;
      $general_cond_ChangeOrderCostCodeVal += $changeOrderCostCodeVal;
      $general_cond_revisedScheduledValue += $revisedScheduledValue;
      continue;
    }
    // $currentRetainHtml = "";
    $previousRetainHtml = "";
    $ocoHtml = "";
    
    $currentRetainHtml = <<<CURRENTRETAINVALUE
      <td class="textAlignRight" nowrap>$currentRetainerValueFormatted</td>
CURRENTRETAINVALUE;
    if($showRetainer){
      $previousRetainHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$previousRetainerValueFormatted</td>
PREVIOUSRETAINVALUE;
    }
    if ($corDisplay == 2) {
      $ocoHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$changeOrderCostCodeValFormatted</td>
PREVIOUSRETAINVALUE;
    }
    $narrative_html = '';
    $total_html = '';
    if(!empty($options) && ($options =='1' || $options =='3')){
      $narrative_html = '<td>'.$narrative.'</td>';
      $total_html = '<td></td>';
    }
    $currentReallocation = '';
    if($allocationCount > 0) {  
      $currentReallocation = '<td class="textAlignRight" nowrap>'.$realocationValueFormatted.'</td>';
    }
    $costCodeData = $costCodeDivision.$costCodeDividerType.$costCode;
    if ($getCostCodeAlias != '' && $alias_type != 0 && $cost_code_alias == 'true') {
      $costCodeData = $costCodeData.' '.$getCostCodeAlias;
    }
    $wrapStyle = "class='textAlignCenter' nowrap";
    if ($cost_code_alias == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }
    $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items" id="gc-budget-line-items_$drawItemId">
      <td $wrapStyle>$costCodeData</td>
      <td class="" nowrap>$costCodeDesc</td>
      <td class="textAlignRight" nowrap>$primeOriginalScheduledValue</td>
      <td class="textAlignRight" nowrap>$sumOfPrevRealocationValFormatted</td>
      $currentReallocation
      $ocoHtml
      <td class="textAlignRight" nowrap>$revisedScheduledValueFormatted</td>
      <td class="textAlignRight" nowrap>$previousApp_format</td>
      <td class="textAlignRight" nowrap>$currentApp_format</td>
      <td></td>
      <td class="textAlignRight" nowrap>$totalCompletedApp_format</td>
      <td class="textAlignRight" nowrap>$gc_format</td>
      <td class="textAlignRight" nowrap>$cg_format</td>
      <td class="textAlignRight" nowrap>$totalRetainageFormatted</td>
      $currentRetainHtml
      $previousRetainHtml
      $narrative_html
    </tr>
END_DRAW_TABLE_TBODY;
  }

  if(!empty($options) && ($options =='2' || $options =='3')){

    $general_cond_cg = $general_cond_ScheduledValue - $general_cond_totalCompletedApp;
    $general_cond_gc = ($general_cond_totalCompletedApp / $general_cond_ScheduledValue) * 100;

    $general_cond_ScheduledValue = formatNegativeValues($general_cond_ScheduledValue);
    $general_cond_OriginalScheduledValue = formatNegativeValues($general_cond_OriginalScheduledValue);
    $general_cond_sumOfPreviousRealocationValue = formatNegativeValues($general_cond_sumOfPreviousRealocationValue);
    $general_cond_RealocationValue = formatNegativeValues($general_cond_RealocationValue);
    $general_cond_ChangeOrderCostCodeVal = formatNegativeValues($general_cond_ChangeOrderCostCodeVal);
    $general_cond_revisedScheduledValue = formatNegativeValues($general_cond_revisedScheduledValue);
    $general_cond_previousApp = formatNegativeValues($general_cond_previousApp);
    $general_cond_previousApp = formatNegativeValues($general_cond_previousApp);
    $general_cond_currentApp = formatNegativeValues($general_cond_currentApp);
    $general_cond_totalCompletedApp = formatNegativeValues($general_cond_totalCompletedApp);
    $general_cond_totalRetainage = formatNegativeValues($general_cond_totalRetainage);
    $general_cond_cg = formatNegativeValues($general_cond_cg);
    $general_cond_gc = formatNegativeValuesWithoutSymbol($general_cond_gc, 2);

    // $general_cond_currentRetainHtml="";
    $general_cond_previousRetainHtml="";
    $general_cond_currentRetainerValue = formatNegativeValues($general_cond_currentRetainerValue);
    $general_cond_currentRetainHtml = <<<CURRENTRETAINVALUE
      <td class="textAlignRight" nowrap>$general_cond_currentRetainerValue</td>
CURRENTRETAINVALUE;
     if($showRetainer){      
      $general_cond_previousRetainerValue = formatNegativeValues($general_cond_previousRetainerValue);  
      $general_cond_previousRetainHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$general_cond_previousRetainerValue</td>
PREVIOUSRETAINVALUE;
    }

    $generalcond = DrawItems::getDrawItemsWithOutChangeOrderGeneral($database, $drawId,$options);
    if(!empty($generalcond['division_number']) && !empty($generalcond['division_code_heading'])){
      $generalconditions = $generalcond['division_number'].$costCodeDividerType.$generalcond['division_code_heading'];
      $generalconditions_div = $generalcond['division'];
    }else{
      $generalconditions = '00'.$costCodeDividerType.'000';
      $generalconditions_div = 'General Requirements';
    }

    if(!empty($options) && $options =='3'){
      $total_html = '<td></td>';
    }
    $genCurrentReallocation = '';
    if($allocationCount > 0) {  
      $genCurrentReallocation = '<td class="textAlignRight" nowrap>'.$general_cond_RealocationValue.'</td>';
    }
    $genOcoHtml = "";
    if ($corDisplay == 2) {
      $genOcoHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$general_cond_ChangeOrderCostCodeVal</td>
PREVIOUSRETAINVALUE;
    }

    $wrapStyle = "class='textAlignCenter' nowrap";
    if ($cost_code_alias == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }
    
    $general_condtbody = <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items" id="gc-budget-line-items_$drawItemId">
      <td $wrapStyle>$generalconditions</td>
      <td nowrap>$generalconditions_div</td>
      <td class="textAlignRight" nowrap>$general_cond_OriginalScheduledValue</td>
      <td class="textAlignRight" nowrap>$general_cond_sumOfPreviousRealocationValue</td>
      $genCurrentReallocation
      $genOcoHtml
      <td class="textAlignRight" nowrap>$general_cond_revisedScheduledValue</td>
      <td class="textAlignRight" nowrap>$general_cond_previousApp</td>
      <td class="textAlignRight" nowrap>$general_cond_currentApp</td>
      <td></td>
      <td class="textAlignRight" nowrap>$general_cond_totalCompletedApp</td>
      <td class="textAlignRight" nowrap>$general_cond_gc</td>
      <td class="textAlignRight" nowrap>$general_cond_cg</td>
      <td class="textAlignRight" nowrap>$general_cond_totalRetainage</td>
      $general_cond_currentRetainHtml
      $general_cond_previousRetainHtml
      $total_html
    </tr>
END_DRAW_TABLE_TBODY;

  $budgetListTableBody = $general_condtbody.$budgetListTableBody;
  }


  $balanceCG = $totalBudgetScheduledValue - $totalBudgetCompletedApp;
  $totalBudgetCompletionPercentage = ($totalBudgetCompletedApp/$totalBudgetScheduledValue)*100;

  $returnArr['totalScheduleValue'] = $totalBudgetScheduledValue;
  $returnArr['totalOriginalScheduledValue'] = $totalOriginalScheduledValue;
  $returnArr['totalCoPreviousAppValule'] = $totalBudgetPreviousApp;
  $returnArr['totalCoCurrentAppValue'] = $totalBudgetCurrentApp;
  $returnArr['totalCoCompletedAppValue'] = $totalBudgetCompletedApp;
  $returnArr['totalCoCompletedPercentage'] = $totalBudgetCompletionPercentage;
  $returnArr['totalBalanceValue'] = $balanceCG;
  $returnArr['totalCoRetainageValue'] = $totalBudgetRetainage;
  $returnArr['totalPrevRetainerValue'] = $totalPrevRetainerValue;
  $returnArr['totalBudgetRealocation'] = $totalBudgetRealocation;
  $returnArr['totalPrevRealocation'] = $totalPreviousRealocationValue;
  $returnArr['totalChangeOrderCostCodeVal'] = $totalChangeOrderCostCodeVal;
  $returnArr['totalCoCurrentRetainage'] = $totalCoCurrentRetainage;
  $returnArr['totalrevisedScheduledValue'] = $totalrevisedScheduledValue;

  $totalCompletedPer = ($totalBudgetCompletedApp/$totalBudgetScheduledValue)*100;
  $totalCompletedPer = formatNegativeValuesWithoutSymbol($totalCompletedPer);

  $balanceCG =  $balanceCG ? formatNegativeValues($balanceCG) : '$0.00';
  $totalBudgetScheduledValue =  $totalBudgetScheduledValue ? formatNegativeValues($totalBudgetScheduledValue) : '';
  $totalOriginalScheduledValue = $totalOriginalScheduledValue ? formatNegativeValues($totalOriginalScheduledValue) : '$0.00';
  $totalBudgetPreviousApp =  $totalBudgetPreviousApp ? formatNegativeValues($totalBudgetPreviousApp) : '$0.00';
  $totalBudgetCurrentApp =  $totalBudgetCurrentApp ? formatNegativeValues($totalBudgetCurrentApp) : '$0.00';
  $totalBudgetCompletedApp =  $totalBudgetCompletedApp ? formatNegativeValues($totalBudgetCompletedApp) : '$0.00';
  $totalBudgetRetainage =  $totalBudgetRetainage ? formatNegativeValues($totalBudgetRetainage) : '$0.00';
  $totalPrevRetainerValue =  $totalPrevRetainerValue ? formatNegativeValues($totalPrevRetainerValue) : '$0.00';
  $totalCurrentRetainerValue =  $totalCoCurrentRetainage ? formatNegativeValues($totalCoCurrentRetainage) : '$0.00';
  $totalBudgetRealocation = formatNegativeValues($totalBudgetRealocation);
  $totalPreviousRealocationValue = formatNegativeValues($totalPreviousRealocationValue);
  $totalChangeOrderCostCodeVal = formatNegativeValues($totalChangeOrderCostCodeVal);
  $totalrevisedScheduledValue = formatNegativeValues($totalrevisedScheduledValue);

  // $currentToRetainHtml = "";
  $previousToRetainHtml = "";  
    $currentToRetainHtml = <<<CURRENTRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalCurrentRetainerValue</td>
CURRENTRETAINVALUE;
  if($showRetainer){
    $previousToRetainHtml = <<<PREVIOUSRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalPrevRetainerValue</td>
PREVIOUSRETAINVALUE;
  }
  $totalCurrentReallocation = '';
  if($allocationCount > 0) {  
    $totalCurrentReallocation = '<td class="textAlignRight textBold" nowrap>'.$totalBudgetRealocation.'</td>';
  }
  $totalOcoHtml = "";
  if ($corDisplay == 2) {
    $totalOcoHtml = <<<PREVIOUSRETAINVALUE
    <td class="textAlignRight textBold" nowrap>$totalChangeOrderCostCodeVal</td>
PREVIOUSRETAINVALUE;
  }
  $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items">
      <td class="textAlignRight textBold" colspan="2" nowrap>TOTAL</td>
      <td class="textAlignRight textBold" nowrap>$totalOriginalScheduledValue</td>
      <td class="textAlignRight textBold" nowrap>$totalPreviousRealocationValue</td>
      $totalCurrentReallocation
      $totalOcoHtml
      <td class="textAlignRight textBold" nowrap>$totalrevisedScheduledValue</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetPreviousApp</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetCurrentApp</td>
      <td class="textAlignRight textBold" nowrap>$0.00</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetCompletedApp</td>
      <td class="textAlignRight textBold" nowrap>$totalCompletedPer</td>
      <td class="textAlignRight textBold" nowrap>$balanceCG</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetRetainage</td>
      $currentToRetainHtml
      $previousToRetainHtml
      $total_html
    </tr>
END_DRAW_TABLE_TBODY;

    $returnArr['budgetListTableBody'] = $budgetListTableBody;

  return $returnArr;
}

/**
 * change order grid html for print pdf
 */
function renderChangeOrderGridHtmlForPDF($database,$projectId, $drawId, $applicationNumber, $showRetainer = false, $options = '',$corDisplay=0,$cost_code_alias = ''){

  $allocationCount = DrawItems::checkReallocationExists($database,$drawId); 
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';
  $changeOrderRequests = DrawItems::getDrawItemsOnlyChangeOrder($database,$drawId,$options,$corType);
  $changeOrderListTableBody = '';
  $orderTableBody = '';
  $totalApprovedCORValue = 0;
  $totalCoPreviousApp = 0;
  $totalCoCurrentApp = 0;
  $totalCoCurrentRetainage = 0;
  $totalCoCompletedApp = 0;
  $totalCoCompletedPercentage = 0;
  $totalCoRetainage = 0;
  $totalCoPreviousRetainage =0;
  $changeOrderRequests = unique_array($changeOrderRequests,'change_order_id');
  foreach ($changeOrderRequests as $key => $changeOrderValue) {
     $drawItemId = $changeOrderValue['id'];
    $changeOrderId = $changeOrderValue['change_order_id'];
    $changeOrderTitle = $changeOrderValue['co_title'];
    $changeOrderPrefix = $changeOrderValue['co_type_prefix'];
    $scheduledValue = $changeOrderValue['co_total'];
    $totalApprovedCORValue += $scheduledValue;
    $retainerRate  = $changeOrderValue['retainer_rate'];
    $narrative = $changeOrderValue['narrative'];
    $currentApp = $changeOrderValue['current_app'];
    $totalCoCurrentApp += $currentApp;
    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$changeOrderId,'change_order_id',$drawItemId,$applicationNumber,$corType);
    $projectPreviousCompletion = DrawItems::getPreviousCOValues($database, $projectId,$changeOrderId, $drawItemId);

    $totalCoPreviousApp += $previousDrawValue['current_app'];
    $totalCompletedApp = (float)$previousDrawValue['current_app'] + (float)$currentApp;
    $totalCompletedAppFormatted = $totalCompletedApp ? formatNegativeValuesWithoutSymbol($totalCompletedApp) : 0;
    $totalCoCompletedApp += $totalCompletedApp;
    $totalRetainage = ((float)$previousDrawValue['current_retainer_value']+(float)$changeOrderValue['current_retainer_value']);
    $totalCoRetainage += $totalRetainage;

    $perviousCompletedPercent = ((float)$totalCompletedApp / (float)$scheduledValue)*100;
    $perviousCompletedPercentFormatted = $perviousCompletedPercent ? formatNegativeValuesWithoutSymbol($perviousCompletedPercent) : '';

    $previousRetainerValue = $previousDrawValue['current_retainer_value'];
    $totalCoPreviousRetainage += $previousRetainerValue;
    $currentRetainerValue = $changeOrderValue['current_retainer_value'];
    $currentRetainerValueFormatted = ($currentRetainerValue && $currentRetainerValue !='0.00') ? formatNegativeValues($currentRetainerValue) : '';
    $previousRetainerValueFormatted = !empty($previousRetainerValue) ? formatNegativeValues($previousRetainerValue) : '';
    $totalCoCurrentRetainage += $currentRetainerValue;

    $totalcG = $scheduledValue - $totalCompletedApp;
    $primeScheduledValue =  $scheduledValue ? formatNegativeValues($scheduledValue) : '';
    $totalCompletedApp =  $totalCompletedApp ? formatNegativeValues($totalCompletedApp) : '';
    $previousApp =  $previousDrawValue['current_app']  ? formatNegativeValues($previousDrawValue['current_app'] ) : '';
    $currentApp =  $currentApp ? formatNegativeValues($currentApp) : '';
    $totalcG =  $totalcG ? formatNegativeValues($totalcG) : '';
    $totalRetainageFormatted = $totalRetainage ? formatNegativeValues($totalRetainage) : '';
    // $currentRetainHtml = "";
    $previousRetainHtml = "";
    $currentRetainHtml = <<<CURRENTRETAINVALUE
      <td class="textAlignRight" nowrap>$currentRetainerValueFormatted</td>
CURRENTRETAINVALUE;
    if($showRetainer){
      $previousRetainHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$previousRetainerValueFormatted</td>
PREVIOUSRETAINVALUE;
    }
    $currentReallocation = '';
    if($allocationCount > 0) {  
      $currentReallocation = '<td></td>';
    }
    $narrative_html = '';
    $total_html = '';
    if(!empty($options) && ($options =='1' || $options =='3')){
        $narrative_html = '<td>'.$narrative.'</td>';
        $total_html = '<td></td>';
    }
    $changeOrderOcoHtml = "";
    if ($corDisplay == 2) {
      $changeOrderOcoHtml = '<td></td>';
    }
    $wrapStyle = "class='textAlignCenter' nowrap";
    if ($cost_code_alias == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }
    $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="change_orders_row" id="change-orders_$drawItemId">
      <td $wrapStyle>$changeOrderPrefix</td>
      <td class="" nowrap>$changeOrderTitle</td>
      <td></td>
      $currentReallocation
      $changeOrderOcoHtml
      <td></td>      
      <td class="textAlignRight" nowrap>$primeScheduledValue</td>
      <td class="textAlignRight" nowrap>$previousApp</td>
      <td class="textAlignRight" nowrap>$currentApp</td>
      <td></td>
      <td class="textAlignRight" nowrap>$totalCompletedApp</td>
      <td class="textAlignRight" nowrap>$perviousCompletedPercentFormatted</td>
      <td class="textAlignRight" nowrap >$totalcG</td>
      <td class="textAlignRight" nowrap>$totalRetainageFormatted</td>
      $currentRetainHtml
      $previousRetainHtml
      $narrative_html
    </tr>
END_DRAW_TABLE_TBODY;
  }

  $orderTableBody .= $changeOrderListTableBody;
  $totalcG = $totalApprovedCORValue - $totalCoCompletedApp;

  $totalCoCompletedPercentage = ($totalCoCompletedApp/$totalApprovedCORValue)*100;
  $returnArr['totalScheduleValue'] = $totalApprovedCORValue;
  $returnArr['totalCoPreviousAppValule'] = $totalCoPreviousApp;
  $returnArr['totalCoCurrentAppValue'] = $totalCoCurrentApp;
  $returnArr['totalCoCompletedAppValue'] = $totalCoCompletedApp;
  $returnArr['totalCoCurrentRetainage'] = $totalCoCurrentRetainage;
  $returnArr['totalPrevRetainerValue'] = $totalCoPreviousRetainage;
  $returnArr['totalCoCompletedPercentage'] = $totalCoCompletedPercentage;
  $returnArr['totalBalanceValue'] = $totalcG;
  $returnArr['totalCoRetainageValue'] = $totalCoRetainage;

  $totalCoCompletedPercentage = $totalCoCompletedPercentage ? formatNegativeValuesWithoutSymbol($totalCoCompletedPercentage) : '0.00';

  $totalCoPreviousApp =  $totalCoPreviousApp ? formatNegativeValues($totalCoPreviousApp) : '$0.00';
  $totalCoCurrentApp =  $totalCoCurrentApp ? formatNegativeValues($totalCoCurrentApp) : '$0.00';
  $totalcG =  $totalcG ? formatNegativeValues($totalcG) : '$0.00';
  $totalCoRetainage =  $totalCoRetainage ? formatNegativeValues($totalCoRetainage) : '$0.00';
  $totalCoCompletedApp =  $totalCoCompletedApp ? formatNegativeValues($totalCoCompletedApp) : '$0.00';
  $totalApprovedCORValue =  $totalApprovedCORValue ? formatNegativeValues($totalApprovedCORValue) : '$0.00';
  $totalcG =  $totalcG ? formatNegativeValues($totalcG) : '$0.00';
  $totalPrevRetainerValue =  $totalCoPreviousRetainage ? formatNegativeValues($totalCoPreviousRetainage) : '$0.00';
  $totalCurrentRetainerValue =  $totalCoCurrentRetainage ? formatNegativeValues($totalCoCurrentRetainage) : '$0.00';

  // $currentToRetainHtml = "";
  $previousToRetainHtml = "";  
  $currentToRetainHtml = <<<CURRENTRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalCurrentRetainerValue</td>
CURRENTRETAINVALUE;
    if($showRetainer){
    $previousToRetainHtml = <<<PREVIOUSRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalPrevRetainerValue</td>
PREVIOUSRETAINVALUE;
  }
  $currentReallocation = '';
    if($allocationCount > 0) {  
      $currentReallocation = '<td class="textBold textAlignRight" nowrap>$0.00</td>';
    }
  if(!empty($options) && ($options =='1' || $options =='3')){
    $total_html = '<td></td>';
  }
   $orderTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="change_orders_row">
      <td class="textBold textAlignRight" colspan="2">TOTAL</td>
      <td class="textBold textAlignRight" nowrap>$0.00</td>
      $currentReallocation
      $changeOrderOcoHtml
      <td class="textBold textAlignRight" nowrap>$0.00</td>
      <td class="textBold textAlignRight" nowrap>$totalApprovedCORValue</td>
      <td class="textBold textAlignRight" nowrap>$totalCoPreviousApp</td>
      <td class="textBold textAlignRight" nowrap>$totalCoCurrentApp</td>
      <td class="textBold textAlignRight" nowrap>$0.00</td>
      <td class="textBold textAlignRight" nowrap>$totalCoCompletedApp</td>
      <td class="textBold textAlignRight" nowrap>$totalCoCompletedPercentage</td>
      <td class="textBold textAlignRight" nowrap >$totalcG</td>
      <td class="textBold textAlignRight" nowrap>$totalCoRetainage</td>
      $currentToRetainHtml
      $previousToRetainHtml
      $total_html
    </tr>
END_DRAW_TABLE_TBODY;

  $returnArr['orderTableBody'] = $orderTableBody;
  return $returnArr;
}

function unique_array($my_array, $key) { 
    $result = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($my_array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $result[$i] = $val; 
        } 
        $i++; 
    } 
    return $result; 
} 
/**
 * change order Aadditions & deductions html for print pdf
 */
function renderChangeOrderValuesForPDF($database,$projectId, $drawId, $applicationNumber){
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';
  $changeOrderRequests = DrawItems::getDrawItemsOnlyChangeOrder($database,$drawId,'',$corType);

  $prevtotalDeductionValue = 0;
  $prevtotalAdditionValue = 0;
  $totalAdditionValue = 0;
  $totalDeductionValue = 0;
  $changeOrderRequests = unique_array($changeOrderRequests,'change_order_id');
  foreach ($changeOrderRequests as $key => $changeOrderValue) {

    $changeOrderId = $changeOrderValue['change_order_id'];
    $drawItemId = $changeOrderValue['id'];

    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$changeOrderId,'change_order_id',$drawItemId,$applicationNumber,$corType);
    $current_app = $previousDrawValue['current_app'];

    $scheduledValue = $changeOrderValue['co_total'];

    if($current_app < 0) {
      $prevtotalDeductionValue += $current_app;
    } else {
      $prevtotalAdditionValue += $current_app;
    }
   
    if($scheduledValue < 0) {
      $totalDeductionValue += $scheduledValue;
    } else {
      $totalAdditionValue += $scheduledValue;
    }
  }
  $returnArr = array();
  $returnArr['totalAdditionValue'] = $totalAdditionValue;
  $returnArr['totalDeductionValue'] = $totalDeductionValue;
  $returnArr['prevtotalAdditionValue'] = $prevtotalAdditionValue;
  $returnArr['prevtotalDeductionValue'] = $prevtotalDeductionValue;

  return $returnArr;
}
// breakdown html
function renderBreakdownHtml($database, $projectId, $drawId, $drawItemId,  $applicationNumber,$isDrawDisbaled) {
  
  $drawBreakdownId = 0;
  $incre = 1;
  $jsArray = array(
    'projectId' => intVal($projectId),
    'drawId' => intVal($drawId),
    'drawItemId' => intVal($drawItemId),
    'drawBreakdownId' => 0,
    'uniqueId' => $incre
  );
  $jsOptionJson = json_encode($jsArray);
  $uniqueId = $drawItemId.'--'.$incre;
  $breakDownHtmltd = "";
   // get all signature Types
  $loadBreakDownsOptions = new Input();
  $loadBreakDownsOptions->forceLoadFlag = true;
  $arrBreakDownsArr = DrawBreakDowns::loadAllDrawBreakDowns($database, $drawItemId, $loadBreakDownsOptions);

  $incre = 1;
  $curr_per_total = 0;
  $base_per_total = 0;
  foreach($arrBreakDownsArr as $drawBreakdownId => $breakdown) {
    $jsArray = array(
    'projectId' => intVal($projectId),
    'drawId' => intVal($drawId),
    'drawItemId' => intVal($drawItemId),
    'drawBreakdownId' => $drawBreakdownId,
    'uniqueId' => $incre
  );
  $jsOptionJson = json_encode($jsArray);
  $uniqueId = $drawItemId.'--'.$incre;
  $base_per = $breakdown->base_per;
  $item = $breakdown->item;
  $curr_per = $breakdown->current_per;
  $base_per_total += $base_per;
  $curr_per_total += $curr_per;
  // Format::formatCurrency
  $curr_per_format = ($curr_per);
  $base_per_format = ($base_per);
  $prev_per = $breakdown->prev_per;
  $removehtml = '';
  if($item == 'NULL' || $item == null){
    $item = '';
  }
  if($incre != 1 && !$isDrawDisbaled) {
    $removehtml=<<<html
    <a class="cursorPoint" onclick="removeRowBreakdown(&quot;record_container--removable_draw--breakdown&quot;,&quot;manage_draw--draw_breakdown_id&quot;, &quot;$uniqueId&quot;, $isDrawDisbaled)"><span class="entypo-cancel-circled"></span></a>
html;
  }

  if($isDrawDisbaled){

    $baseInputHtml = <<<BASE_INPUT_HTML
    <div class="textAlignRight">$base_per_format<div>
BASE_INPUT_HTML;

    $itemInputHtml = <<<ITEM_INPUT_HTML
    <div class="textAlignRight">$item<div>
ITEM_INPUT_HTML;

    $previousInputHtml = <<<PREV_INPUT_HTML
    <div class="textAlignRight">$prev_per<div>
PREV_INPUT_HTML;

    $currentInputHtml = <<<CURRENT_INPUT_HTML
    <div class="textAlignRight">$curr_per_format<div>
CURRENT_INPUT_HTML;

  }else{
    $baseInputHtml = <<<BASE_INPUT_HTML
    <input class="breakDownTxt textAlignRight" onchange='onChangeBDVal(this, "manage_draw--breakdown_base", "$uniqueId", $jsOptionJson)'  onkeypress="return isNumberKey(this, event)"  id="manage_draw--breakdown_base$uniqueId" type="text" value="$base_per_format"/>
BASE_INPUT_HTML;
    $itemInputHtml = <<<ITEM_INPUT_HTML
    <input class="breakDownTxt textAlignRight" id="manage_draw--breakdown_item$uniqueId" type="text" onchange='onChangeBDVal(this, "manage_draw--breakdown_item", "$uniqueId", $jsOptionJson)' value="$item"/>
ITEM_INPUT_HTML;
    $previousInputHtml = <<<PREV_INPUT_HTML
    <input readonly="readonly" class="breakDownTxt textAlignRight readOnly" id="manage_draw--breakdown_prev$uniqueId" type="text" onchange='onChangeBDVal(this, "manage_draw--breakdown_prev", "$uniqueId", $jsOptionJson)' value="$prev_per"/>
PREV_INPUT_HTML;
    $currentInputHtml = <<<CURRENT_INPUT_HTML
    <input onkeypress="return isNumberKey(this, event)"  class="breakDownTxt textAlignRight" id="manage_draw--breakdown_curr$uniqueId" type="text" onchange='onChangeBDVal(this, "manage_draw--breakdown_curr", "$uniqueId", $jsOptionJson)' value="$curr_per_format"/>
CURRENT_INPUT_HTML;
  }
  $breakDownHtmltd .= <<<BREAKDOWNHTML
  <tr id="record_container--removable_draw--breakdown$uniqueId" class="">
    <td>
    <input type="hidden" id='manage_draw--draw_breakdown_id$uniqueId' value="$drawBreakdownId"/>
     $baseInputHtml
    </td>
    <td>$itemInputHtml</td>
    <td>$previousInputHtml</td>
    <td>$currentInputHtml</td>
    <td>$removehtml</td>
  </tr>
BREAKDOWNHTML;
  $incre++;
}
$base_per_total = number_format($base_per_total, 2);
$curr_per_total = number_format($curr_per_total, 2);
if(!isset($arrBreakDownsArr) || empty($arrBreakDownsArr)) {

  if($isDrawDisbaled){
    $baseInputHtml = <<<BASE_INPUT_HTML
    <div class="textAlignRight">0<div>
BASE_INPUT_HTML;

    $itemInputHtml = <<<ITEM_INPUT_HTML
    <div class="textAlignRight">0<div>
ITEM_INPUT_HTML;

    $previousInputHtml = <<<PREV_INPUT_HTML
    <div class="textAlignRight">0<div>
PREV_INPUT_HTML;

    $currentInputHtml = <<<CURRENT_INPUT_HTML
    <div class="textAlignRight">0<div>
CURRENT_INPUT_HTML;

  }else{
    $baseInputHtml = <<<BASE_INPUT_HTML
    <input class="breakDownTxt textAlignRight" onchange='onChangeBDVal(this, "manage_draw--breakdown_base", "$uniqueId", $jsOptionJson)'  id="manage_draw--breakdown_base$uniqueId" type="text" value=""/>
BASE_INPUT_HTML;

    $itemInputHtml = <<<ITEM_INPUT_HTML
    <input class="breakDownTxt" id="manage_draw--breakdown_item$uniqueId" type="text" onchange='onChangeBDVal(this, "manage_draw--breakdown_item", "$uniqueId", $jsOptionJson)' value=""/>
ITEM_INPUT_HTML;

    $previousInputHtml = <<<PREV_INPUT_HTML
    <input readonly="readonly" class="breakDownTxt textAlignRight readOnly" id="manage_draw--breakdown_prev$uniqueId" type="text" onchange='onChangeBDVal(this, "manage_draw--breakdown_prev", "$uniqueId", $jsOptionJson)' value=""/>
PREV_INPUT_HTML;

    $currentInputHtml = <<<CURRENT_INPUT_HTML
    <input class="breakDownTxt textAlignRight" id="manage_draw--breakdown_curr$uniqueId" type="text" onchange='onChangeBDVal(this, "manage_draw--breakdown_curr", "$uniqueId", $jsOptionJson)' value=""/>
CURRENT_INPUT_HTML;
  }

  $breakDownHtmltd .= <<<BREAKDOWNHTML
  <tr id="record_container--removable_draw--breakdown$uniqueId" class="">
    <td>
    <input type="hidden" id='manage_draw--draw_breakdown_id$uniqueId' value="$drawBreakdownId"/>
    $baseInputHtml
    </td>
    <td>$itemInputHtml</td>
    <td>$previousInputHtml</td>
    <td>$currentInputHtml</td>
    <td></td>
  </tr>
BREAKDOWNHTML;
}
 $breakdownAddButton = '';
 if(!$isDrawDisbaled){
  $breakdownAddButton = <<<ADD_BUTTON_HTML
  <input type="button" value="Add Row" onclick="addBreakdownNewRow('manage_draw','$drawItemId', $drawId, $projectId)">
ADD_BUTTON_HTML;
 }
  $breakDownHtml = <<<BREAKDOWNHTML
    <table width="100%" class="table-border-none">
      <thead id="breakdownTableContentBody$drawItemId">
        <tr>
          <th colspan="5" class="textAlignRight">
            <input type="hidden" id='manage_draw--draw_breakdown_count$drawItemId' value="$incre"/>
              $breakdownAddButton
          </th>
        </tr>
        <tr class="textAlignLeft">
          <td>Base %</td>
          <td>Item</td>
          <td>Prev %</td>
          <td>Curr %</td>
        </tr>
        $breakDownHtmltd
      </thead>
      <tbody >
        <tr class="textAlignRight" id="breakdownTableContentBodyTotal$drawItemId">
          <td id="manage_draw--breakdown_base--total$drawItemId">$base_per_total</td>
          <td ></td>
          <td id="manage_draw--breakdown_prev--total$drawItemId">0.00</td>
          <td id="manage_draw--breakdown_curr--total$drawItemId">$curr_per_total</td>
        </tr>
      </tbody>
    </table>
BREAKDOWNHTML;
    return $breakDownHtml;
}

function formatNegativeValues($number){
  if($number < 0){
    $number = abs($number);
    $number = Format::formatCurrency($number);
    $formattedNumber = '('.$number.')';
  }else{
    $formattedNumber = Format::formatCurrency($number);
  }
  return $formattedNumber;
}

function formatNegativeValuesWithoutSymbol($number){
  if($number < 0){
    $number = abs($number);
    $number = numberFormat($number);
    $formattedPercent = '('.$number.')';
  }else{
    $formattedPercent = numberFormat($number);
  }
  return $formattedPercent;
}

/**
*To generate Retention Module List
*/
function renderCreateRetentionHtml($database,$projectId,$applicationId){
  $permissions = Zend_Registry::get('permissions');
  $userCanViewDraws = checkPermissionForAllModuleAndRole($database,'view_draws');
  $userCanEditDraws = checkPermissionForAllModuleAndRole($database,'edit_draws');
  $userCanPostDraws = checkPermissionForAllModuleAndRole($database,'post_draws');

  $session = Zend_Registry::get('session');
  $userRole = $session->getUserRole();
  $debugMode = $session->getDebugMode();
  /* get recent Retention draw count */
  $getRecentRetentionId = RetentionDraws::getRetentionRecentCount($database, $projectId, $applicationId);
  $RetentionData = RetentionDraws::getRetentionData($database,$projectId,$applicationId);
  $project = Project::findProjectByIdExtended($database, $projectId);
  $retTemplateId = $project->draw_template_id;
  if(empty($retTemplateId)){
    $retTemplateId = 0;
  }
  if(!empty($RetentionData)){
    $RetentionId = $RetentionData['id'];
    $RetentionStatus = $RetentionData['status'];
    $applicationNumber = $RetentionData['application_number'];
    $isRetentionDisbaled = false;
    $disabled = '';
    if($RetentionStatus == 2){
      $isRetentionDisbaled = true;
      $disabled = 'disabled="disabled"';
    }
    $throughDate = date('m/d/Y',strtotime($RetentionData['through_date']));
    $invoiceDate = date('m/d/Y',strtotime($RetentionData['invoice_date']));

    $arrCountOfDraftRetention = RetentionDraws::findDraftDrawCountUsingRetentionId($database, $projectId, $RetentionId);
    $getCountOfDraftDraw = $arrCountOfDraftRetention['rowCount'];
    /* check the draw if posted */
    $readOnlyClass = '';
    $readOnlyClassPostDraw = '';
    $onClickFunction = "onclick='saveDrawAsDraft($RetentionId)'";
    if($RetentionData['status'] == 2){
      $readOnlyClassPostDraw = 'disabled="disabled"';
      $onClickFunction = "onclick='saveDraftAsFromPostDrawConfirmation($RetentionId)'";
      if($getCountOfDraftDraw > 0){
        $onClickFunction = "onclick='saveDrawAsDraft($RetentionId)'";
      }

      if($getRecentRetentionId == $RetentionId){
        $readOnlyClass = '';
      } else {
        $readOnlyClass = 'disabled="disabled"';
      }
    } else {
      $readOnlyClass = '';
    }

  $saveButtonsHtml = <<<END_BUTTON_HTML_CONTENT
  <li class="" style="margin: 5px 0px 0px 5px;"><br/><input type="button" $readOnlyClassPostDraw value="Save as draft" $onClickFunction></li>
END_BUTTON_HTML_CONTENT;
  if($userCanPostDraws || $userRole == "global_admin"){
    $saveButtonsHtml .= <<<END_BUTTON_HTML_CONTENT
    <li class="" style="margin: 5px 0px 0px 5px;"><br/>(OR)</li>
    <li class="" style="margin: 5px 0px 0px 5px;"><br/><input $readOnlyClassPostDraw type="button" value="Post Retention Draw" onclick='postRetentionDraw($RetentionId);'></li>
END_BUTTON_HTML_CONTENT;
  }
  $throughDateHtml = <<<END_HTML_CONTENT
  <div class="datepicker_style_custom">
  <input id="draw_items--through_date--$RetentionId" $disabled class="through_datepicker drawDateCls" type="text" placeholder="Pick a Date" onchange="updateDrawDate(this, '');" value="$throughDate"><img class="through_datepicker dateDivSecCalIcon" width="13" src="./images/cal.png">
  </div>

END_HTML_CONTENT;
  $invoiceDateHtml = <<<END_HTML_CONTENT
  <div class="datepicker_style_custom">
  <input id="draw_items--invoice_date--$RetentionId" $disabled class="through_datepicker drawDateCls" type="text" placeholder="Pick a Date" onchange="updateInvoiceDate(this, '');" value="$invoiceDate"><img class="through_datepicker invoicedateDivSecCalIcon" width="13" src="./images/cal.png">
  </div>

END_HTML_CONTENT;
  /* Get Action Types*/
  $loadarrDrawActionOptions = new Input();
  $loadarrDrawActionOptions->forceLoadFlag = true;
  $loadarrDrawActionOptions->arrOrderByAttributes = array(
    'dat.`id`' => 'ASC'
  );
  $arrDrawActionTypes = DrawActionTypes::loadAllDrawActionTypes($database, $loadarrDrawActionOptions);
  $actionTypeHtmlOption = "";
  foreach($arrDrawActionTypes as $drawActionTypeId => $actionType) {
    $draw_action_type_id = $actionType->draw_action_type_id;
    $xlsx_download = $actionType->xlsx_download;
    $pdf_download = $actionType->pdf_download;
    $option_name = $actionType->action_name;
    $action_option = $actionType->action_option;
    $actionTypeValue = array();
    $actionTypeValue['draw_action_type_id'] = $draw_action_type_id;
    $actionTypeValue['action_option'] = $action_option;
    $actionTypeValue['pdf_download'] = $pdf_download;
    $actionTypeValue['xlsx_download'] = $xlsx_download;
    // $actionTypeValue['attribute'] = 'select_action_type_option';
    $actionTypeValueJson = implode('--', $actionTypeValue);
    $actionTypeHtmlOption .= <<<ACTIONTYPEHTML
    <option value='$actionTypeValueJson'>$option_name</option>
ACTIONTYPEHTML;
    //  check the condition if only continue else return to the loop
    if($action_option != 'Y') {
      continue;
    }
  }

  if($debugMode){
    $drawIdHtml = <<<END_DRAW_ID_DEBUG_HTML
        <li class="textAlignCenter">
          <div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
            <span>RETENTION ID</span><br/> <span class="textColorBlue">$RetentionId</span>
          </div>
        </li>
END_DRAW_ID_DEBUG_HTML;
  }else{
    $drawIdHtml = '';
  }


  $applicationNumberHtml = <<<END_APPLICATION_NUMBER
  <div class="">
  <ul class="griddetail-deltalane griddetail-deltaactions">
    <li class="float-none m-b-20"><input type="button" value="Back" onclick="gotoDrawList()"></li>
    $drawIdHtml
    <li class="textAlignCenter"><span>Application Number:</span><br/> <span class="textColorBlue">$applicationNumber</span></li>
    <li><span class="">Through Date:<br/></span> $throughDateHtml</li>
    <li><span class="">Invoice Date:<br/></span> $invoiceDateHtml</li>
    <!-- retention starts-->
    <li style="margin-left: 5px; margin-right: 5px;">
          <span>Retention Actions<br/></span>
          <table>
            <tr>
              <td>
                <select id="manage_retention--select_action_type" onchange="retchangeSubOptionVal(this,$retTemplateId)">
                 <option value="0">Select Type</option>
                 $actionTypeHtmlOption
                </select>
              </td>
              <td>
                <select id="manage_retention--select_action_type_option" onchange="onchangeSubOrderChangeValue()" style="width:101px;">
                 <option value="">Select Option</option>
                </select>
              </td>
              <td id="multiselectoption" style="display:none;width:150px;">
              
                <select id="export_option" multiple="true" style="width: 100%; height: 125px;">
                  <option value="">Select Export Option</option>
                  <option value="general_condition_summary" >General Conditions Summary Only</option>
                  <option value="narrative_column">Narrative Column</option>
                  <option value="cost_code_alias">Cost Code Aliases</option>                  
                </select>
              </td>
              <td>
                <a onclick="clickToGenerateRetentionPdfBasedActionType()"><img style="display:none;" class="downloadImg pdfDownload bs-tooltip" title="PDF Download" src="./images/icons/pdf-download.png"></a>
              </td>
              <td>
                <a onclick="generateDrawAsExcel($RetentionId,$applicationNumber,0)"><img style="display:none;" class="downloadImg xlsxDownload bs-tooltip" title="XLSX Download" src="./images/icons/xlsx-download.png"></a>
              </td>
            </tr>
          </table>
        </li>
      <!-- retention ends pdf-->
    
    $saveButtonsHtml
  </ul>
  </div>
END_APPLICATION_NUMBER;
  $textAlign = 'align="center"';
  $budgetGridHtml = renderRetentionBudgetGridHtml($database,$projectId,$RetentionId,$applicationNumber,$isRetentionDisbaled);
  $budgetGridBody = $budgetGridHtml['budgetListTableBody'];
  $getTabIndex = $budgetGridHtml['tabIndex'];
  $totalBudgetScheduledRetentionValue = $budgetGridHtml['totalBudgetScheduledRetentionValue'];
  $totalBudgetCurrentRetainage = $budgetGridHtml['totalBudgetCurrentRetainage'];
  $totalBudgetPreviousRetainage = $budgetGridHtml['totalBudgetPreviousRetainage'];
  $totalBudgetCurrentRetainerValue = $budgetGridHtml['totalBudgetCurrentRetainerValue'];
  $totalBudgetPercentageCompleted = $budgetGridHtml['totalBudgetPercentageCompleted'];



  $totalBudgetScheduledRetentionValueFormatted = $totalBudgetScheduledRetentionValue ? Format::formatCurrency($totalBudgetScheduledRetentionValue) : '$0.00';
  $totalBudgetCurrentRetainageFormatted = $totalBudgetCurrentRetainage ? Format::formatCurrency($totalBudgetCurrentRetainage) : '$0.00';
  $totalBudgetPreviousRetainageFormatted = $totalBudgetPreviousRetainage ? Format::formatCurrency($totalBudgetPreviousRetainage) : '$0.00';
  $totalBudgetCurrentRetainerValueFormatted = $totalBudgetCurrentRetainerValue ? Format::formatCurrency($totalBudgetCurrentRetainerValue) : '$0.00';
  $totalBudgetPercentageCompletedFormatted = $totalBudgetPercentageCompleted ? Format::formatCurrency($totalBudgetPercentageCompleted) : '';


  if($debugMode){
    $colSpan = 5;
  }else{
    $colSpan = 1;
  }

  $totalBudgetScheduledRetentionValueClass = $totalBudgetScheduledRetentionValue < 0 ? 'red' : '';
  $totalBudgetCurrentRetainageClass = $totalBudgetCurrentRetainage < 0 ? 'red' : '';
  $totalBudgetPreviousRetainageClass = $totalBudgetPreviousRetainage < 0 ? 'red' : '';
  $totalBudgetCurrentRetainerValueClass = $totalBudgetCurrentRetainerValue < 0 ? 'red' : '';
  $totalBudgetPercentageCompletedClass = $totalBudgetPercentageCompleted < 0 ? 'red' : '';

  $budgetTotalHtml = "<tr class='purStyle lightgray-bg'>
  <td colspan='$colSpan'></td>
  <td align='right'><b>Total</b></td>
  <td align='right'><b><div class='$totalBudgetScheduledRetentionValueClass'>$totalBudgetScheduledRetentionValueFormatted</div></b></td>  
  <td align='right'><b><div class='$totalBudgetCurrentRetainageClass'>$totalBudgetCurrentRetainageFormatted</div></b></td>
    <td align='right'><b><div class='$totalBudgetPreviousRetainageClass'>$totalBudgetPreviousRetainageFormatted </div></b></td>
  <td align='right'><b><div class='$totalBudgetCurrentRetainerValueClass'>$totalBudgetCurrentRetainerValueFormatted</div></b></td>
  <!--<td align='right'><b><div class='$totalBudgetPercentageCompletedClass'>$totalBudgetPercentageCompletedFormatted </div></b></td>-->  
  <td colspan='1'></td>
  </tr>";

  $changeOrderGridHtml = renderRetentionChangeOrderGridHtml($database,$projectId,$RetentionId,$applicationNumber,$isRetentionDisbaled, $getTabIndex);
  $orderTableBody = $changeOrderGridHtml['orderTableBody'];
  $totalCOScheduledRetentionValue = $changeOrderGridHtml['totalCOScheduledRetentionValue'];
  $totalCOCurrentRetainage = $changeOrderGridHtml['totalCOCurrentRetainage'];
  $totalCOPreviousRetainage = $changeOrderGridHtml['totalCOPreviousRetainage'];
  $totalCOCurrentRetainerValue = $changeOrderGridHtml['totalCOCurrentRetainerValue'];
  $totalCOPercentageCompleted = $changeOrderGridHtml['totalCOPercentageCompleted'];

  $totalCOScheduledRetentionValueFormatted = $totalCOScheduledRetentionValue ? Format::formatCurrency($totalCOScheduledRetentionValue) : '$0.00';
  $totalCOCurrentRetainageFormatted = $totalCOCurrentRetainage ? Format::formatCurrency($totalCOCurrentRetainage) : '$0.00';
  $totalCOPreviousRetainageFormatted = $totalCOPreviousRetainage ? Format::formatCurrency($totalCOPreviousRetainage) : '$0.00';
  $totalCOCurrentRetainerValueFormatted = $totalCOCurrentRetainerValue ? Format::formatCurrency($totalCOCurrentRetainerValue) : '$0.00';
  $totalCOPercentageCompletedFormatted = $totalCOPercentageCompleted ? Format::formatCurrency($totalCOPercentageCompleted) : '';

  $totalCOScheduledRetentionValueClass = $totalCOScheduledRetentionValue < 0 ? 'red' : '';
  $totalCOCurrentRetainageClass = $totalCOCurrentRetainage < 0 ? 'red' : '';
  $totalCOPreviousRetainageClass = $totalCOPreviousRetainage < 0 ? 'red' : '';
  $totalCOCurrentRetainerValueClass = $totalCOCurrentRetainerValue < 0 ? 'red' : '';
  $totalCOPercentageCompletedClass = $totalCOPercentageCompleted < 0 ? 'red' : '';

  $changeOrderTotalHtml = "<tr class='purStyle lightgray-bg'>
  <td colspan='$colSpan'></td>
  <td align='right'><b>Total</b></td>
  <td align='right'><b><div class='$totalCOScheduledRetentionValueClass'>$totalCOScheduledRetentionValueFormatted</div></b></td>
  <td align='right'><b><div class='$totalCOCurrentRetainageClass'>$totalCOCurrentRetainageFormatted</div></b></td>
  <td align='right'><b><div class='$totalCOPreviousRetainageClass'>$totalCOPreviousRetainageFormatted</div></b></td>
  <td align='right'><b><div class='$totalCOCurrentRetainerValueClass'>$totalCOCurrentRetainerValueFormatted</div></b></td>
  <!--<td align='right'><b><div class='$totalCOPercentageCompletedClass'>$totalCOPercentageCompletedFormatted</div></b></td>-->
  <td colspan='1'></td>
  </tr>";


  $totalProjectScheduledValue = $totalBudgetScheduledRetentionValue+$totalCOScheduledRetentionValue;
  $totalProjectCurrentRetainage = $totalBudgetCurrentRetainage+$totalCOCurrentRetainage;
  $totalProjectPreviousRetainage = $totalBudgetPreviousRetainage+$totalCOPreviousRetainage;
  $totalProjectCurrentRetainageValue = $totalBudgetCurrentRetainerValue+$totalCOCurrentRetainerValue;
  $totalProjectPercentageCompleted = $totalBudgetPercentageCompleted+$totalCOPercentageCompleted;

  // $totalProjectCompletionPercentage = ($totalProjectCompletedApp/$totalProjectScheduledValue)*100;


  $totalProjectScheduledValueFormatted = $totalProjectScheduledValue ? Format::formatCurrency($totalProjectScheduledValue) : '$0.00';
  $totalProjectCurrentRetainageFormatted = $totalProjectCurrentRetainage ? Format::formatCurrency($totalProjectCurrentRetainage) : '$0.00';
  $totalProjectPreviousRetainageFormatted = $totalProjectPreviousRetainage ? Format::formatCurrency($totalProjectPreviousRetainage) : '$0.00';
  $totalProjectCurrentRetainageValueFormatted = $totalProjectCurrentRetainageValue ? Format::formatCurrency($totalProjectCurrentRetainageValue) : '$0.00';
  $totalProjectPercentageCompletedFormatted = $totalProjectPercentageCompleted ? Format::formatCurrency($totalProjectPercentageCompleted) : '';



  $totalProjectScheduledValueClass = $totalProjectScheduledValue < 0 ? 'red' : '';
  $totalProjectCurrentRetainageClass = $totalProjectCurrentRetainage < 0 ? 'red' : '';
  $totalProjectPreviousRetainageClass = $totalProjectPreviousRetainage < 0 ? 'red' : '';
  $totalProjectCurrentRetainageValueClass = $totalProjectCurrentRetainageValue < 0 ? 'red' : '';
  $totalProjectPercentageCompletedClass = $totalProjectPercentageCompleted < 0 ? 'red' : '';

  $projectTotalHtml = "<tr class='purStyle lightgray-bg'>
  <td colspan='$colSpan'></td>
  <td align='right'><b>Overall Total</b></td>
  <td align='right'><b><div class='$totalProjectScheduledValueClass'>$totalProjectScheduledValueFormatted</div></b></td>
  <td align='right'><b><div class='$totalProjectCurrentRetainageClass'>$totalProjectCurrentRetainageFormatted</div></b></td>
  <td align='right'><b><div class='$totalProjectPreviousRetainageClass'>$totalProjectPreviousRetainageFormatted</div></b></td>
  <td align='right'><b><div class='$totalProjectCurrentRetainageValueClass'>$totalProjectCurrentRetainageValueFormatted</div></b></td>
  <!--<td align='right'><b><div class='$totalProjectPercentageCompletedClass'>$totalProjectPercentageCompletedFormatted</div></b></td>-->

  <td colspan='1'></td>
  </tr>";

  $createDrawGridHtml = '';
  $createDrawGridHtml .= $budgetGridBody;
  $createDrawGridHtml .= $budgetTotalHtml;
  $createDrawGridHtml .= $orderTableBody;
  if($orderTableBody){
    $createDrawGridHtml .= $changeOrderTotalHtml;
    $createDrawGridHtml .= $projectTotalHtml;
  }

  $htmlContent = $applicationNumberHtml;
  if ($debugMode) {
    $debugHeadline =
  '<th>GBLI<br>ID</th>
      <th>CCD<br>ID</th>
      <th>CODE<br>ID</th>
      <th style="min-width:60px">RETENTION ITEM ID</th>';
  } else {
    $debugHeadline = '';
  }
  $htmlContent .= <<<END_HTML_CONTENT

  <table id="createDrawTabularData" class="content c-order notSortable" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
      <tr class="permissionTableMainHeader">
      $debugHeadline
        <th>Cost Code</th>
        <th>Cost Code Description</th>
        <th>Scheduled Value</th>
        <th style="min-width: 85px;">Current Ret. withheld </th>
        <th> Previous Ret. Billed</th>
        <th>Ret. Amount to Bill </th>
        <!--<th> % To Bill</th>-->
        <th>Narrative</th>
      </tr>
    </thead>
    <tbody class="">
       $createDrawGridHtml
    </tbody>
  </table>

END_HTML_CONTENT;

   return $htmlContent;
  }else{
    header("Location:modules-draw-list.php");
    exit;
  }
}

/**
 * Retention budget grid html
 */
function renderRetentionBudgetGridHtml($database,$projectId,$RetentionId,$applicationNumber,$isDrawDisbaled){
  $session = Zend_Registry::get('session');
  $user_company_id = $session->getUserCompanyId();
  $debugMode = $session->getDebugMode();
  $budgetList = RetentionItems::getBudgetGridRetentionItems($database,$RetentionId);
  

  $budgetListTableBody = '';
  $totalBudgetScheduledRetentionValue = 0;
  $totalBudgetCurrentRetainage = 0;
  $totalBudgetPreviousRetainage = 0;
  $totalBudgetCurrentRetainerValue = 0; 
  $totalBudgetPercentageCompleted = 0; 

  $tab1 = 2001;
  $tab2 = 0;
  $tab3 = 2002;
  //cost code divider
  $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
  $retDisabled="";
  foreach ($budgetList as $key => $value) {
    $retItemId = $value['id'];
    $budgetLineItemId = $value['gc_budget_line_item_id'];
    $costCodeDivision = $value['division_number'];
    $costCodeDivisionId = $value['cost_code_division_id'];
    $costCodeId = $value['cost_code_id'];
    $costCode = $value['cost_code'];
    $costCodeDesc = $value['cost_code_description'];
    $scheduledValue = $value['scheduled_retention_value'];
    $totalBudgetScheduledRetentionValue += $scheduledValue;

    $narrative = $value['narrative'];
    $CurrentRetainage = $value['current_retainage'];
    $totalBudgetCurrentRetainage += $CurrentRetainage;
    if($CurrentRetainage =="0.00" ||$CurrentRetainage <"1")
    {
       $retDisabled="disabled='true'";
    }else
    {
      $retDisabled="";
    }
    $previousRetainage = $value['previous_retainage'];
    $totalBudgetPreviousRetainage += $previousRetainage;
    $currentRetainerValue = $value['current_retainer_value'];
    $totalBudgetCurrentRetainerValue += $currentRetainerValue;
    $BalanceRetainageValue = $value['balance_retainage_value'];
    $percentage_completed =$value['percentage_completed'];
    $totalBudgetPercentageCompleted += $percentage_completed;

    $CurrentRetainage =!empty($CurrentRetainage) ? Format::formatCurrency($CurrentRetainage) : '';
    $previousRetainage =!empty($previousRetainage) ? Format::formatCurrency($previousRetainage) : '$0.00';
    $currentRetainerValue = !empty($currentRetainerValue) ? Format::formatCurrency($currentRetainerValue) : '';
   
    if($isDrawDisbaled){

      $narrativeInput = $narrative;
      $currentRetainerInput = $currentRetainerValue;
      $percentagecompletedInput = $percentage_completed;
    }else{
      $percentagecompletedClass = $percentage_completed < 0 ? "red" : '';
      $currentretainerClass = $currentRetainerValue < 0 ? "red" : '';

      $currentRetainerInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab1" class="current_retainer_value draw_input_value $currentretainerClass" id="retention_items--gc_budget_line_item_id--current_retainer_value--$retItemId" value="$currentRetainerValue" onchange="updateRetainerValue(this,$retItemId,$budgetLineItemId,$RetentionId,&apos;$previousRetainage&apos;,'Current Retainer Value');" style="text-align: right;" $retDisabled>
END_CURRENT_APP_HTML;
 $percentagecompletedInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab2" class="percentage_completed draw_input_value $percentagecompletedClass" id="retention_items--gc_budget_line_item_id--percentage_completed--$retItemId" value="$percentage_completed" onchange="updateRetentionItem(this,$retItemId,$budgetLineItemId,$RetentionId,&apos;$previousRetainage&apos;,'Percentage Completion');" style="text-align: right;"$retDisabled>
END_CURRENT_APP_HTML;
      $narrativeInput = <<<END_NARRATIVE_HTML
      <textarea tabIndex="$tab3" class="scrollbar-design" id="retention_items--gc_budget_line_item_id--narrative--$retItemId" onchange="updateRetentionItem(this,$retItemId,$budgetLineItemId,$RetentionId,&apos;$previousRetainage&apos;,'Narrative');" rows="2" style="width:180px;">$narrative</textarea>
END_NARRATIVE_HTML;
     
    }
    $primeScheduledValue = $scheduledValue ? Format::formatCurrency($scheduledValue) : '';

    $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items ui-sortable-handle" id="gc-budget-line-items_$retItemId">
END_DRAW_TABLE_TBODY;
    if($debugMode){
      $html_gc_budget_line_item_id = (!empty($budgetLineItemId) ? $budgetLineItemId : '&nbsp;');
      $html_cost_code_division_id = (!empty($costCodeDivisionId) ? $costCodeDivisionId : '&nbsp;');
      $html_cost_code_id = (!empty($costCodeId) ? $costCodeId : '&nbsp;');
      $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
          <td>$html_gc_budget_line_item_id</td>
          <td>$html_cost_code_division_id</td>
          <td>$html_cost_code_id</td>
          <td>$retItemId</td>
END_DRAW_TABLE_TBODY;
    }
    $primeScheduledValueClass = $scheduledValue < 0 ? "red" : '';
    $currentRetainerValueClass = $currentRetainerValue < 0 ? "red" : '';
    $previousRetainageClass = $previousRetainage < 0 ? "red" : '';

    $costCodeData = $costCodeDivision.$costCodeDividerType.$costCode;
$budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
      <td class="textAlignCenter" nowrap">$costCodeData</td>
      <td class="" nowrap>$costCodeDesc</td>
      <td class="textAlignRight" nowrap><div class="$primeScheduledValueClass">$primeScheduledValue</div></td>
      <td class="textAlignRight" nowrap id="draw_items--gc_budget_line_item_id--current_retainage--$retItemId">$CurrentRetainage</td>
      <td class="textAlignRight" nowrap>$previousRetainage </td>
      <td class="textAlignRight" nowrap>$currentRetainerInput</td>
      <!--<td class="textAlignRight" nowrap>$percentagecompletedInput</td>-->
      <td class="textAlignCenter" nowrap>$narrativeInput</td>
    </tr>
END_DRAW_TABLE_TBODY;
$tab1 = $tab1+2;
// $tab2 = $tab2+3;
$tab3 = $tab3+2;
  }

  $returnArr['totalBudgetScheduledRetentionValue'] = $totalBudgetScheduledRetentionValue;
  $returnArr['totalBudgetCurrentRetainage'] = $totalBudgetCurrentRetainage;
  $returnArr['totalBudgetPreviousRetainage'] = $totalBudgetPreviousRetainage;
  $returnArr['totalBudgetCurrentRetainerValue'] = $totalBudgetCurrentRetainerValue;
  $returnArr['totalBudgetPercentageCompleted'] = $totalBudgetPercentageCompleted;
  $returnArr['budgetListTableBody'] = $budgetListTableBody;
  $returnArr['tabIndex'] = $tab3;
  return $returnArr;
}

/**
 * Retention change order grid html
 */
function renderRetentionChangeOrderGridHtml($database,$projectId,$RetentionId,$applicationNumber,$isDrawDisbaled, $getTabIndex=1){
  $changeOrderRequests = RetentionItems::getChangeOrderRetentionItems($database,$RetentionId);
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';
  $session = Zend_Registry::get('session');
  $debugMode = $session->getDebugMode();
  $changeOrderListTableBody = '';
  $orderTableHeader = '';
  $orderTableBody = '';
  $totalCOScheduledRetentionValue = 0;
  $totalCOCurrentRetainage = 0;
  $totalCOPreviousRetainage = 0;
  $totalCOCurrentRetainerValue = 0; 
  $totalCOPercentageCompleted = 0; 

  $project = Project::findProjectByIdExtended($database, $projectId);    
  $OCODisplay = $project->COR_type;

  $tab1 = $getTabIndex-2;
  $tab2 = $getTabIndex-1;
  $tab3 = $getTabIndex;
  foreach ($changeOrderRequests as $key => $changeOrderValue) {
    $RetItemId = $changeOrderValue['id'];
    $changeOrderId = $changeOrderValue['change_order_id'];
    $changeOrderTitle = $changeOrderValue['co_title'];
    $changeOrderPrefix = $changeOrderValue['co_type_prefix'];
    $scheduledValue = $changeOrderValue['scheduled_retention_value'];
    $totalCOScheduledRetentionValue += $scheduledValue;
    $currentRetainage  = $changeOrderValue['current_retainage'];
    $totalCOCurrentRetainage += $currentRetainage;
    $previousRetainage  = $changeOrderValue['previous_retainage'];

    $totalCOPreviousRetainage +=$previousRetainage;
     if($currentRetainage =="0.00" ||$currentRetainage <"1")
    {
       $retDisabled="disabled='true'";
    }else
    {
      $retDisabled="";
    }


    $narrative = $changeOrderValue['narrative'];
    $percentageCompleted = $changeOrderValue['percentage_completed'];
    $totalCOPercentageCompleted += $percentageCompleted;
    
    $currentRetainerValue = $changeOrderValue['current_retainer_value'];
    $totalCOCurrentRetainerValue += $currentRetainerValue;
    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$changeOrderId,'change_order_id',$RetItemId,$applicationNumber,$corType);
    $projectPreviousCompletion = DrawItems::getPreviousCOValues($database, $projectId,$changeOrderId, $RetItemId);
 
    $currentRetainerValue = $currentRetainerValue ? Format::formatCurrency($currentRetainerValue) : '';
    $currentRetainage = $currentRetainage ? Format::formatCurrency($currentRetainage) : '';
    $previousRetainage =!empty($previousRetainage) ? Format::formatCurrency($previousRetainage) : '$0.00';

    if($isDrawDisbaled){
      $completionPercentageInput = $percentageCompleted;
      $currentRetainerValueInput = $currentRetainerValue;
      $narrativeInput = $narrative;
      $currentRetainageInput = $currentRetainage;
    }else{
      $PercentagecompletedClass = $percentageCompleted < 0 ? "red" : '';
      $currentRetainerValueClass = $percentageCompleted < 0 ? "red" : '';

      $currentRetainerValueInput = <<<END_CURRENT_APP_HTML
      <input tabIndex="$tab1" class="current_retainer_value draw_input_value $currentRetainerValueClass" id="draw_items--change_order_id--current_retainer_value--$RetItemId" value="$currentRetainerValue" onchange="updateRetainerValue(this,$RetItemId,$changeOrderId,$RetentionId,&apos;$previousRetainage&apos;,'Current Retainer Value');" style="text-align: right;" $retDisabled>
END_CURRENT_APP_HTML;

 $completionPercentageInput = <<<END_COMPLETION_PERCENTAGE_HTML
      <input tabIndex="$tab2" class="percentage_completed draw_input_value $PercentagecompletedClass" id="draw_items--change_order_id--percentage_completed--$RetItemId" value="$percentageCompleted" onchange="updateRetentionItem(this,$RetItemId,$changeOrderId,$RetentionId,&apos;$previousRetainage&apos;,'Percentage Completion');" style="text-align: right;" $retDisabled>
END_COMPLETION_PERCENTAGE_HTML;

      $narrativeInput = <<<END_NARRATIVE_HTML
      <textarea tabIndex="$tab3" class="scrollbar-design" id="draw_items--change_order_id--narrative--$RetItemId" onchange="updateRetentionItem(this,$RetItemId,$changeOrderId,$RetentionId,&apos;$previousRetainage&apos;,'Narrative');" rows="2" style="width:180px;">$narrative</textarea>
END_NARRATIVE_HTML;

    }
    $primeScheduledValue = $scheduledValue ? '$'.$scheduledValue : '';

    $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="change_orders_row ui-sortable-handle" id="change-orders_$RetItemId">
END_DRAW_TABLE_TBODY;
    if($debugMode){
      $html_change_order_id = (!empty($changeOrderId) ? $changeOrderId : '&nbsp;');
      $html_cost_code_division_id = '&nbsp;';
      $html_cost_code_id = '&nbsp;';
      $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
          <td>$html_change_order_id</td>
          <td>$html_cost_code_division_id</td>
          <td>$html_cost_code_id</td>
          <td>$RetItemId</td>
END_DRAW_TABLE_TBODY;
    }
    $primeScheduledValueClass = $scheduledValue < 0 ? "red" : '';
    $currentRetainerValueClass = $currentRetainerValue < 0 ? "red" : '';
    $previousRetainageClass = $previousRetainage < 0 ? "red" : '';
    $previousRetainage =!empty($previousRetainage) ? Format::formatCurrency($previousRetainage) : '$0.00';
    // breakDown Values html
    $breakDownHtml = renderBreakdownHtml($database, $projectId, $RetentionId, $RetItemId, $applicationNumber,$isDrawDisbaled);
    $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
      <td class="textAlignCenter" nowrap>$changeOrderPrefix</td>
      <td class="" nowrap>$changeOrderTitle</td>
      <td class="textAlignRight" nowrap><div class="$primeScheduledValueClass">$primeScheduledValue</div></td>
      <td class="textAlignRight" nowrap>$currentRetainage</td>
      <td class="textAlignRight" nowrap>$previousRetainage</td>


       <td class="textAlignRight" nowrap>$currentRetainerValueInput</td>
        <!--<td class="textAlignRight" nowrap>$completionPercentageInput</td>-->
        <td class="textAlignCenter" nowrap>$narrativeInput</td>
    </tr>
END_DRAW_TABLE_TBODY;
$tab1 = $tab1+3;
$tab2 = $tab2+3;
$tab3 = $tab3+3;
  }
  if ($OCODisplay == 1) {
    if(count($changeOrderRequests)>0){
      if($debugMode){
        $titleColSpan = 17;
      }else{
        $titleColSpan = 13;
      }
      $orderTableHeader .= "<tr class='purStyle lightgray-bg'><td colspan='$titleColSpan'><b>Change Order Request</b></td></td></tr>";
      $orderTableBody .= $orderTableHeader;
    }
    $orderTableBody .= $changeOrderListTableBody;
  }

  $returnArr['totalCOScheduledRetentionValue'] = $totalCOScheduledRetentionValue;
  $returnArr['totalCOCurrentRetainage'] = $totalCOCurrentRetainage;
  $returnArr['totalCOPreviousRetainage'] = $totalCOPreviousRetainage;
  $returnArr['totalCOCurrentRetainerValue'] = $totalCOCurrentRetainerValue;
  $returnArr['totalCOPercentageCompleted'] = $totalCOPercentageCompleted;
  $returnArr['orderTableBody'] = $orderTableBody;
  return $returnArr;
}

function renderRetentionDrawGridHtmlForPDF($database,$projectId, $drawId, $applicationNumber, $showRetainer = false,$options='',$corDisplay=0,$cost_code_alias='',$ret_id=''){

  $allocationCount = DrawItems::checkReallocationExists($database,$drawId);
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $budgetList = DrawItems::getBudgetDrawItems($database,$drawId,$options,$cor_type);
  $session = Zend_Registry::get('session');
  $user_company_id = $session->getUserCompanyId();
  $project = Project::findProjectByIdExtended($database, $projectId);
  $alias_type = $project->alias_type;
  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';

  //cost code divider
  $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
  $budgetListTableBody = '';
  $totalBudgetScheduledValue = $totalrevisedScheduledValue = $totalOriginalScheduledValue= $totalCoCurrentRetainage = $totalPrevRetainerValue = 0;
  $totalBudgetRealocation = $totalPreviousRealocationValue = $totalChangeOrderCostCodeVal = 0;
  $totalRetBillAmt = 0;
  $totalBudgetPreviousApp = 0;
  $totalBudgetCurrentApp = 0;
  $totalBudgetCompletedApp = 0;
  $totalBudgetRetainage = 0;
  $totalBudgetCompletionPercentage = 0;
  $general_cond_ScheduledValue = $general_cond_previousApp = $general_cond_currentApp = $general_cond_currentRetainerValue = $general_cond_totalCompletedApp = $general_cond_gc = $general_cond_cg = $general_cond_totalRetainage = $general_cond_previousRetainerValue = 0;

  foreach ($budgetList as $key => $value) {
    $drawItemId = $value['id'];
    $budgetLineItemId = $value['gc_budget_line_item_id'];
    $costCodeDivision = $value['division_number'];
    $costCode = $value['cost_code'];
    $cost_code_id = $value['cost_code_id'];
    $cost_code_divison_id = $value['cost_code_divison_id'];
    $costCodeDesc = $value['cost_code_description'];
    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_divison_id);
    $realocationValue = $value['realocation'];
    $totalBudgetRealocation = round(($totalBudgetRealocation+$realocationValue),2);
    $originalScheduledValue = $value['prime_contract_scheduled_value'];
    $scheduledValue = $value['scheduled_value'] + $realocationValue;
    $totalOriginalScheduledValue += $originalScheduledValue;
    $retainerRate  = $value['retainer_rate'];
    $narrative = $value['narrative'];
    $currentApp = $value['current_app'];
    $division_number_group_id = $value['division_number_group_id'];
    $totalBudgetCurrentApp += $currentApp;
    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$budgetLineItemId,'gc_budget_line_item_id',$drawItemId,$applicationNumber,$corType);
    $projectPreviousCompletion = DrawItems::getPreviousBudgetValues($database, $projectId,$budgetLineItemId,$drawItemId,$corType);
    // Sum of previous realocation value 
    $sumOfPreviousRealocationVal = DrawItems::getsumOfPreviousRealocationValue($database,$projectId,$drawId,$budgetLineItemId);    
    $sumOfPreviousRealocationValue = $sumOfPreviousRealocationVal + $realocationValue;
    
    $totalPreviousRealocationValue = round(($totalPreviousRealocationValue+$sumOfPreviousRealocationValue),2);
    // Sum of change order cost code value
    $changeOrderCostCodeVal = $scheduledValue - $originalScheduledValue - $realocationValue - $sumOfPreviousRealocationValue;
    $totalChangeOrderCostCodeVal += $changeOrderCostCodeVal;

    $retBilliAmtDet = RetentionItems::getRetBillingAmtByRetIdAndLineItemId($database,$ret_id,$budgetLineItemId,'gc_budget_line_item_id');
    $retBillAmt = $retBilliAmtDet['current_retainer_value'];
    $totalRetBillAmt = round(($totalRetBillAmt+$retBillAmt),2);

   
    if ($corDisplay == 2) {
      $revisedScheduledValue = $scheduledValue;
      $totalrevisedScheduledValue += $revisedScheduledValue;
      $totalBudgetScheduledValue += $scheduledValue;
    }else{
      $revisedScheduledValue = $originalScheduledValue+$realocationValue+$sumOfPreviousRealocationValue;
      $totalrevisedScheduledValue += $revisedScheduledValue;
      $scheduledValue = $revisedScheduledValue;
      $totalBudgetScheduledValue += $scheduledValue;
    }

    $totalBudgetPreviousApp += $previousDrawValue['current_app'];
    $totalCompletedApp = (float)$previousDrawValue['current_app'] + (float)$currentApp;
    $totalBudgetCompletedApp += $totalCompletedApp;
    $totalRetainage = ((float)$previousDrawValue['current_retainer_value']+(float)$value['current_retainer_value']);
    $totalRetainage = (float)$totalRetainage - (float)$retBillAmt;

    $totalBudgetRetainage += $totalRetainage;
    $previousRetainerValue = $previousDrawValue['current_retainer_value'] + $value['current_retainer_value'];
    $currentRetainerValue = $value['current_retainer_value'];
    $totalCoCurrentRetainage += $currentRetainerValue;
    $totalPrevRetainerValue += $previousRetainerValue;
    if ($currentRetainerValue && $currentRetainerValue !='0.00') {
     $currentRetainerValueFormatted = formatNegativeValues($currentRetainerValue);
    }else{
      $currentRetainerValueFormatted = '';
    }
    $previousRetainerValueFormatted = !empty($previousRetainerValue) ? formatNegativeValues($previousRetainerValue) : '';
    $sumOfPrevRealocationValFormatted = ($sumOfPreviousRealocationValue != '0.00') ? formatNegativeValues($sumOfPreviousRealocationValue) : '';
    $realocationValueFormatted = ($realocationValue != '0.00') ? formatNegativeValues($realocationValue) : '';
    $changeOrderCostCodeValFormatted = $changeOrderCostCodeVal ? formatNegativeValues($changeOrderCostCodeVal) : '';
    $revisedScheduledValueFormatted = formatNegativeValues($revisedScheduledValue);
    // totalcompleted / schedule values
    $gc = ($totalCompletedApp / $scheduledValue)*100;
    $cg = $scheduledValue - $totalCompletedApp;
    $totalCompletedApp_format = formatNegativeValues($totalCompletedApp);
    $gc_format = $gc ? formatNegativeValuesWithoutSymbol($gc, 2) : '';
    $cg_format = $cg ? formatNegativeValues($cg) : '';
    $primeScheduledValue = $scheduledValue ? formatNegativeValues($scheduledValue) : '';
    $primeOriginalScheduledValue = $originalScheduledValue ? formatNegativeValues($originalScheduledValue) : '';
    $currentApp_format =  $currentApp ? formatNegativeValues($currentApp) : '';
    $previousApp = $previousDrawValue['current_app'];
    $previousApp_format = formatNegativeValues($previousApp);
    $totalRetainageFormatted =  $totalRetainage ? formatNegativeValues($totalRetainage) : '';
    $retBillFormatted = $retBillAmt ? formatNegativeValues($retBillAmt) : '';

    if(!empty($options) && ($options =='2' || $options =='3')  && !empty($division_number_group_id) && $division_number_group_id =='1'){ // General Conditions
      $general_cond_ScheduledValue += $scheduledValue;
      $general_cond_OriginalScheduledValue += $originalScheduledValue;
      $general_cond_previousApp += $previousApp;
      $general_cond_currentApp += $currentApp;
      $general_cond_currentRetainerValue += $currentRetainerValue;
      $general_cond_totalCompletedApp += $totalCompletedApp;
      $general_cond_totalRetainage += $totalRetainage;
      $general_cond_previousRetainerValue += $previousRetainerValue;
      $general_cond_sumOfPreviousRealocationValue += $sumOfPreviousRealocationValue;
      $general_cond_RealocationValue += $realocationValue;
      $general_cond_ChangeOrderCostCodeVal += $changeOrderCostCodeVal;
      $general_cond_revisedScheduledValue += $revisedScheduledValue;
      $general_cond_retBillAmt += $retBillAmt;
      continue;
    }
    // $currentRetainHtml = "";
    $previousRetainHtml = "";
    $ocoHtml = "";
    
    $currentRetainHtml = <<<CURRENTRETAINVALUE
      <td class="textAlignRight" nowrap>$currentRetainerValueFormatted</td>
CURRENTRETAINVALUE;
    if($showRetainer){
      $previousRetainHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$previousRetainerValueFormatted</td>
PREVIOUSRETAINVALUE;
    }
    if ($corDisplay == 2) {
      $ocoHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$changeOrderCostCodeValFormatted</td>
PREVIOUSRETAINVALUE;
    }
    $narrative_html = '';
    $total_html = '';
    if(!empty($options) && ($options =='1' || $options =='3')){
      $narrative_html = '<td>'.$narrative.'</td>';
      $total_html = '<td></td>';
    }
    
    $costCodeData = $costCodeDivision.$costCodeDividerType.$costCode;
    if ($getCostCodeAlias != '' && $alias_type != 0 && $cost_code_alias == 'true') {
      $costCodeData = $costCodeData.' '.$getCostCodeAlias;
    }
    $wrapStyle = "class='textAlignCenter' nowrap";
    if ($cost_code_alias == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }
    $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items" id="gc-budget-line-items_$drawItemId">
      <td $wrapStyle>$costCodeData</td>
      <td class="" nowrap>$costCodeDesc</td>
      <td class="textAlignRight" nowrap>$primeOriginalScheduledValue</td>
      <td class="textAlignRight" nowrap>$sumOfPrevRealocationValFormatted</td>
      $ocoHtml
      <td class="textAlignRight" nowrap>$revisedScheduledValueFormatted</td>
      <td class="textAlignRight" nowrap>$previousApp_format</td>
      <td class="textAlignRight" nowrap>$currentApp_format</td>
      <td></td>
      <td class="textAlignRight" nowrap>$totalCompletedApp_format</td>
      <td class="textAlignRight" nowrap>$gc_format</td>
      <td class="textAlignRight" nowrap>$cg_format</td>
      <td class="textAlignRight" nowrap>$totalRetainageFormatted</td>
      <td class="textAlignRight" nowrap>$retBillFormatted</td>      
      $previousRetainHtml
      $narrative_html
    </tr>
END_DRAW_TABLE_TBODY;
  }

  if(!empty($options) && ($options =='2' || $options =='3')){

    $general_cond_cg = $general_cond_ScheduledValue - $general_cond_totalCompletedApp;
    $general_cond_gc = ($general_cond_totalCompletedApp / $general_cond_ScheduledValue) * 100;

    $general_cond_ScheduledValue = formatNegativeValues($general_cond_ScheduledValue);
    $general_cond_OriginalScheduledValue = formatNegativeValues($general_cond_OriginalScheduledValue);
    $general_cond_sumOfPreviousRealocationValue = formatNegativeValues($general_cond_sumOfPreviousRealocationValue);
    $general_cond_RealocationValue = formatNegativeValues($general_cond_RealocationValue);
    $general_cond_ChangeOrderCostCodeVal = formatNegativeValues($general_cond_ChangeOrderCostCodeVal);
    $general_cond_revisedScheduledValue = formatNegativeValues($general_cond_revisedScheduledValue);
    $general_cond_previousApp = formatNegativeValues($general_cond_previousApp);
    $general_cond_previousApp = formatNegativeValues($general_cond_previousApp);
    $general_cond_currentApp = formatNegativeValues($general_cond_currentApp);
    $general_cond_totalCompletedApp = formatNegativeValues($general_cond_totalCompletedApp);
    $general_cond_totalRetainage = formatNegativeValues($general_cond_totalRetainage);
    $general_cond_cg = formatNegativeValues($general_cond_cg);
    $general_cond_gc = formatNegativeValuesWithoutSymbol($general_cond_gc, 2);
    $general_cond_retBillAmt = formatNegativeValues($general_cond_retBillAmt);

    // $general_cond_currentRetainHtml="";
    $general_cond_previousRetainHtml="";
    $general_cond_currentRetainerValue = formatNegativeValues($general_cond_currentRetainerValue);
    $general_cond_currentRetainHtml = <<<CURRENTRETAINVALUE
      <td class="textAlignRight" nowrap>$general_cond_currentRetainerValue</td>
CURRENTRETAINVALUE;
     if($showRetainer){      
      $general_cond_previousRetainerValue = formatNegativeValues($general_cond_previousRetainerValue);  
      $general_cond_previousRetainHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$general_cond_previousRetainerValue</td>
PREVIOUSRETAINVALUE;
    }

    $generalcond = DrawItems::getDrawItemsWithOutChangeOrderGeneral($database, $drawId,$options);
    if(!empty($generalcond['division_number']) && !empty($generalcond['division_code_heading'])){
      $generalconditions = $generalcond['division_number'].$costCodeDividerType.$generalcond['division_code_heading'];
      $generalconditions_div = $generalcond['division'];
    }else{
      $generalconditions = '00'.$costCodeDividerType.'000';
      $generalconditions_div = 'General Requirements';
    }

    if(!empty($options) && $options =='3'){
      $total_html = '<td></td>';
    }
    $genOcoHtml = "";
    if ($corDisplay == 2) {
      $genOcoHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$general_cond_ChangeOrderCostCodeVal</td>
PREVIOUSRETAINVALUE;
    }

    $wrapStyle = "class='textAlignCenter' nowrap";
    if ($cost_code_alias == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }
    
    $general_condtbody = <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items" id="gc-budget-line-items_$drawItemId">
      <td $wrapStyle>$generalconditions</td>
      <td nowrap>$generalconditions_div</td>
      <td class="textAlignRight" nowrap>$general_cond_OriginalScheduledValue</td>
      <td class="textAlignRight" nowrap>$general_cond_sumOfPreviousRealocationValue</td>
      $genOcoHtml
      <td class="textAlignRight" nowrap>$general_cond_revisedScheduledValue</td>
      <td class="textAlignRight" nowrap>$general_cond_previousApp</td>
      <td class="textAlignRight" nowrap>$general_cond_currentApp</td>
      <td></td>
      <td class="textAlignRight" nowrap>$general_cond_totalCompletedApp</td>
      <td class="textAlignRight" nowrap>$general_cond_gc</td>
      <td class="textAlignRight" nowrap>$general_cond_cg</td>
      <td class="textAlignRight" nowrap>$general_cond_totalRetainage</td>
      <td class="textAlignRight" nowrap>$general_cond_retBillAmt</td>
      $general_cond_previousRetainHtml
      $total_html
    </tr>
END_DRAW_TABLE_TBODY;

  $budgetListTableBody = $general_condtbody.$budgetListTableBody;
  }


  $balanceCG = $totalBudgetScheduledValue - $totalBudgetCompletedApp;
  $totalBudgetCompletionPercentage = ($totalBudgetCompletedApp/$totalBudgetScheduledValue)*100;

  $returnArr['totalScheduleValue'] = $totalBudgetScheduledValue;
  $returnArr['totalOriginalScheduledValue'] = $totalOriginalScheduledValue;
  $returnArr['totalCoPreviousAppValule'] = $totalBudgetPreviousApp;
  $returnArr['totalCoCurrentAppValue'] = $totalBudgetCurrentApp;
  $returnArr['totalCoCompletedAppValue'] = $totalBudgetCompletedApp;
  $returnArr['totalCoCompletedPercentage'] = $totalBudgetCompletionPercentage;
  $returnArr['totalBalanceValue'] = $balanceCG;
  $returnArr['totalCoRetainageValue'] = $totalBudgetRetainage;
  $returnArr['totalPrevRetainerValue'] = $totalPrevRetainerValue;
  $returnArr['totalBudgetRealocation'] = $totalBudgetRealocation;
  $returnArr['totalPrevRealocation'] = $totalPreviousRealocationValue;
  $returnArr['totalChangeOrderCostCodeVal'] = $totalChangeOrderCostCodeVal;
  $returnArr['totalCoCurrentRetainage'] = $totalCoCurrentRetainage;
  $returnArr['totalrevisedScheduledValue'] = $totalrevisedScheduledValue;
  $returnArr['totalRetBillAmt'] = $totalRetBillAmt;

  $totalCompletedPer = ($totalBudgetCompletedApp/$totalBudgetScheduledValue)*100;
  $totalCompletedPer = formatNegativeValuesWithoutSymbol($totalCompletedPer);

  $balanceCG =  $balanceCG ? formatNegativeValues($balanceCG) : '$0.00';
  $totalBudgetScheduledValue =  $totalBudgetScheduledValue ? formatNegativeValues($totalBudgetScheduledValue) : '';
  $totalOriginalScheduledValue = $totalOriginalScheduledValue ? formatNegativeValues($totalOriginalScheduledValue) : '$0.00';
  $totalBudgetPreviousApp =  $totalBudgetPreviousApp ? formatNegativeValues($totalBudgetPreviousApp) : '$0.00';
  $totalBudgetCurrentApp =  $totalBudgetCurrentApp ? formatNegativeValues($totalBudgetCurrentApp) : '$0.00';
  $totalBudgetCompletedApp =  $totalBudgetCompletedApp ? formatNegativeValues($totalBudgetCompletedApp) : '$0.00';
  $totalBudgetRetainage =  $totalBudgetRetainage ? formatNegativeValues($totalBudgetRetainage) : '$0.00';
  $totalPrevRetainerValue =  $totalPrevRetainerValue ? formatNegativeValues($totalPrevRetainerValue) : '$0.00';
  $totalCurrentRetainerValue =  $totalCoCurrentRetainage ? formatNegativeValues($totalCoCurrentRetainage) : '$0.00';
  $totalBudgetRealocation = formatNegativeValues($totalBudgetRealocation);
  $totalPreviousRealocationValue = formatNegativeValues($totalPreviousRealocationValue);
  $totalChangeOrderCostCodeVal = formatNegativeValues($totalChangeOrderCostCodeVal);
  $totalrevisedScheduledValue = formatNegativeValues($totalrevisedScheduledValue);
  $totalRetBillAmt = formatNegativeValues($totalRetBillAmt);

  // $currentToRetainHtml = "";
  $previousToRetainHtml = "";  
    $currentToRetainHtml = <<<CURRENTRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalCurrentRetainerValue</td>
CURRENTRETAINVALUE;
  if($showRetainer){
    $previousToRetainHtml = <<<PREVIOUSRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalPrevRetainerValue</td>
PREVIOUSRETAINVALUE;
  }
  $totalOcoHtml = "";
  if ($corDisplay == 2) {
    $totalOcoHtml = <<<PREVIOUSRETAINVALUE
    <td class="textAlignRight textBold" nowrap>$totalChangeOrderCostCodeVal</td>
PREVIOUSRETAINVALUE;
  }
  $budgetListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="gc_budget_line_items">
      <td class="textAlignRight textBold" colspan="2" nowrap>TOTAL</td>
      <td class="textAlignRight textBold" nowrap>$totalOriginalScheduledValue</td>
      <td class="textAlignRight textBold" nowrap>$totalPreviousRealocationValue</td>
      $totalOcoHtml
      <td class="textAlignRight textBold" nowrap>$totalrevisedScheduledValue</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetPreviousApp</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetCurrentApp</td>
      <td class="textAlignRight textBold" nowrap>$0.00</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetCompletedApp</td>
      <td class="textAlignRight textBold" nowrap>$totalCompletedPer</td>
      <td class="textAlignRight textBold" nowrap>$balanceCG</td>
      <td class="textAlignRight textBold" nowrap>$totalBudgetRetainage</td>
      <td class="textAlignRight textBold" nowrap>$totalRetBillAmt</td>
      $previousToRetainHtml
      $total_html
    </tr>
END_DRAW_TABLE_TBODY;

    $returnArr['budgetListTableBody'] = $budgetListTableBody;

  return $returnArr;
}

function renderRetentionChangeOrderGridHtmlForPDF($database,$projectId, $drawId, $applicationNumber, $showRetainer = false, $options = '',$corDisplay=0,$cost_code_alias = '',$ret_id){

  $cor_type = Project::CORAboveOrBelow($database,$projectId);
  $corType = ($cor_type == 2) ? 'A' : 'B';
  $changeOrderRequests = DrawItems::getDrawItemsOnlyChangeOrder($database,$drawId,$options,$corType);

  $changeOrderListTableBody = $orderTableBody = '';

  $totalApprovedCORValue = $totalCoPreviousApp = $totalCoCurrentApp = $totalCoCurrentRetainage = $totalCoCompletedApp = $totalCoCompletedPercentage = $totalCoRetainage = $totalCoPreviousRetainage = $totalCoRetBillAmt = 0;

  foreach ($changeOrderRequests as $key => $changeOrderValue) {

    $drawItemId         = $changeOrderValue['id'];
    $changeOrderId      = $changeOrderValue['change_order_id'];
    $changeOrderTitle   = $changeOrderValue['co_title'];
    $changeOrderPrefix  = $changeOrderValue['co_type_prefix'];
    $scheduledValue     = $changeOrderValue['co_total'];
    $retainerRate       = $changeOrderValue['retainer_rate'];
    $narrative          = $changeOrderValue['narrative'];
    $currentApp         = $changeOrderValue['current_app'];

    $totalApprovedCORValue  += $scheduledValue;
    $totalCoCurrentApp      += $currentApp;

    // To get Retention billing amount
    $retBilliAmtDet = RetentionItems::getRetBillingAmtByRetIdAndLineItemId($database,$ret_id,$changeOrderId,'change_order_id');
    $retBillAmt         = $retBilliAmtDet['current_retainer_value'];
    $totalCoRetBillAmt  = round(($totalCoRetBillAmt+$retBillAmt),2);

    $previousDrawValue = DrawItems::getPreviousDrawValue($database, $projectId,$changeOrderId,'change_order_id',$drawItemId,$applicationNumber,$corType);
    
    $totalCompletedApp  = (float)$previousDrawValue['current_app'] + (float)$currentApp;

    $totalRetainage     = ((float)$previousDrawValue['current_retainer_value']+(float)$changeOrderValue['current_retainer_value']);
    $totalRetainage     = (float)$totalRetainage - (float)$retBillAmt;

    $perviousCompletedPercent = ((float)$totalCompletedApp / (float)$scheduledValue)*100;
    $previousRetainerValue = $previousDrawValue['current_retainer_value'] + $changeOrderValue['current_retainer_value'];
    $currentRetainerValue = $changeOrderValue['current_retainer_value'];
    $totalcG = $scheduledValue - $totalCompletedApp;

    $totalCoPreviousApp       += $previousDrawValue['current_app'];
    $totalCoCompletedApp      += $totalCompletedApp;
    $totalCoRetainage         += $totalRetainage;
    $totalCoPreviousRetainage += $previousRetainerValue;
    $totalCoCurrentRetainage  += $currentRetainerValue;

    $totalCompletedAppFormatted = $totalCompletedApp ? formatNegativeValuesWithoutSymbol($totalCompletedApp) : 0;    
    $perviousCompletedPercentFormatted = $perviousCompletedPercent ? formatNegativeValuesWithoutSymbol($perviousCompletedPercent) : '';    
    $currentRetainerValueFormatted = ($currentRetainerValue && $currentRetainerValue !='0.00') ? formatNegativeValues($currentRetainerValue) : '';
    $previousRetainerValueFormatted = !empty($previousRetainerValue) ? formatNegativeValues($previousRetainerValue) : '';    
    $primeScheduledValue =  $scheduledValue ? formatNegativeValues($scheduledValue) : '';
    $totalCompletedApp =  $totalCompletedApp ? formatNegativeValues($totalCompletedApp) : '';
    $previousApp =  $previousDrawValue['current_app']  ? formatNegativeValues($previousDrawValue['current_app'] ) : '';
    $currentApp =  $currentApp ? formatNegativeValues($currentApp) : '';
    $totalcG =  $totalcG ? formatNegativeValues($totalcG) : '';
    $totalRetainageFormatted = $totalRetainage ? formatNegativeValues($totalRetainage) : '';
    $retBillAmtFormatted = $retBillAmt ? formatNegativeValues($retBillAmt) : '';

    $previousRetainHtml = "";
    $currentRetainHtml = <<<CURRENTRETAINVALUE
      <td class="textAlignRight" nowrap>$currentRetainerValueFormatted</td>
CURRENTRETAINVALUE;

    if($showRetainer){
      $previousRetainHtml = <<<PREVIOUSRETAINVALUE
      <td class="textAlignRight" nowrap>$previousRetainerValueFormatted</td>
PREVIOUSRETAINVALUE;
    }

    $narrative_html = '';
    $total_html = '';
    if(!empty($options) && ($options =='1' || $options =='3')){
        $narrative_html = '<td>'.$narrative.'</td>';
        $total_html = '<td></td>';
    }

    $changeOrderOcoHtml = "";
    if ($corDisplay == 2) {
      $changeOrderOcoHtml = '<td></td>';
    }

    $wrapStyle = "class='textAlignCenter' nowrap";
    if ($cost_code_alias == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }

    $changeOrderListTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="change_orders_row" id="change-orders_$drawItemId">
      <td $wrapStyle>$changeOrderPrefix</td>
      <td class="" nowrap>$changeOrderTitle</td>
      <td></td>
      $changeOrderOcoHtml
      <td></td>      
      <td class="textAlignRight" nowrap>$primeScheduledValue</td>
      <td class="textAlignRight" nowrap>$previousApp</td>
      <td class="textAlignRight" nowrap>$currentApp</td>
      <td></td>
      <td class="textAlignRight" nowrap>$totalCompletedApp</td>
      <td class="textAlignRight" nowrap>$perviousCompletedPercentFormatted</td>
      <td class="textAlignRight" nowrap >$totalcG</td>
      <td class="textAlignRight" nowrap>$totalRetainageFormatted</td>
      <td class="textAlignRight" nowrap>$retBillAmtFormatted</td>
      $previousRetainHtml
      $narrative_html
    </tr>
END_DRAW_TABLE_TBODY;
  }

  $orderTableBody .= $changeOrderListTableBody;
  $totalcG = $totalApprovedCORValue - $totalCoCompletedApp;

  $totalCoCompletedPercentage = ($totalCoCompletedApp/$totalApprovedCORValue)*100;
  $returnArr['totalScheduleValue'] = $totalApprovedCORValue;
  $returnArr['totalCoPreviousAppValule'] = $totalCoPreviousApp;
  $returnArr['totalCoCurrentAppValue'] = $totalCoCurrentApp;
  $returnArr['totalCoCompletedAppValue'] = $totalCoCompletedApp;
  $returnArr['totalCoCurrentRetainage'] = $totalCoCurrentRetainage;
  $returnArr['totalPrevRetainerValue'] = $totalCoPreviousRetainage;
  $returnArr['totalCoCompletedPercentage'] = $totalCoCompletedPercentage;
  $returnArr['totalBalanceValue'] = $totalcG;
  $returnArr['totalCoRetainageValue'] = $totalCoRetainage;
  $returnArr['totalCoRetBillAmt'] = $totalCoRetBillAmt;

  $totalCoCompletedPercentage = $totalCoCompletedPercentage ? formatNegativeValuesWithoutSymbol($totalCoCompletedPercentage) : '0.00';
  $totalCoPreviousApp =  $totalCoPreviousApp ? formatNegativeValues($totalCoPreviousApp) : '$0.00';
  $totalCoCurrentApp =  $totalCoCurrentApp ? formatNegativeValues($totalCoCurrentApp) : '$0.00';
  $totalcG =  $totalcG ? formatNegativeValues($totalcG) : '$0.00';
  $totalCoRetainage =  $totalCoRetainage ? formatNegativeValues($totalCoRetainage) : '$0.00';
  $totalCoCompletedApp =  $totalCoCompletedApp ? formatNegativeValues($totalCoCompletedApp) : '$0.00';
  $totalApprovedCORValue =  $totalApprovedCORValue ? formatNegativeValues($totalApprovedCORValue) : '$0.00';
  $totalcG =  $totalcG ? formatNegativeValues($totalcG) : '$0.00';
  $totalPrevRetainerValue =  $totalCoPreviousRetainage ? formatNegativeValues($totalCoPreviousRetainage) : '$0.00';
  $totalCurrentRetainerValue =  $totalCoCurrentRetainage ? formatNegativeValues($totalCoCurrentRetainage) : '$0.00';
  $totalCoRetBillAmt = $totalCoRetBillAmt ? formatNegativeValues($totalCoRetBillAmt) : '$0.00';

  // $currentToRetainHtml = "";
  $previousToRetainHtml = "";  
  $currentToRetainHtml = <<<CURRENTRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalCurrentRetainerValue</td>
CURRENTRETAINVALUE;
    if($showRetainer){
    $previousToRetainHtml = <<<PREVIOUSRETAINVALUE
    <td class="textBold textAlignRight" nowrap>$totalPrevRetainerValue</td>
PREVIOUSRETAINVALUE;
  }
  
  if(!empty($options) && ($options =='1' || $options =='3')){
    $total_html = '<td></td>';
  }
   $orderTableBody .= <<<END_DRAW_TABLE_TBODY
    <tr class="change_orders_row">
      <td class="textBold textAlignRight" colspan="2">TOTAL</td>
      <td class="textBold textAlignRight" nowrap>$0.00</td>
      $changeOrderOcoHtml
      <td class="textBold textAlignRight" nowrap>$0.00</td>
      <td class="textBold textAlignRight" nowrap>$totalApprovedCORValue</td>
      <td class="textBold textAlignRight" nowrap>$totalCoPreviousApp</td>
      <td class="textBold textAlignRight" nowrap>$totalCoCurrentApp</td>
      <td class="textBold textAlignRight" nowrap>$0.00</td>
      <td class="textBold textAlignRight" nowrap>$totalCoCompletedApp</td>
      <td class="textBold textAlignRight" nowrap>$totalCoCompletedPercentage</td>
      <td class="textBold textAlignRight" nowrap >$totalcG</td>
      <td class="textBold textAlignRight" nowrap>$totalCoRetainage</td>
      <td class="textBold textAlignRight" nowrap>$totalCoRetBillAmt</td>
      $previousToRetainHtml
      $total_html
    </tr>
END_DRAW_TABLE_TBODY;

  $returnArr['orderTableBody'] = $orderTableBody;
  return $returnArr;
}
