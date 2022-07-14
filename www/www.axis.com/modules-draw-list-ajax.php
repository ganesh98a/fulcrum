<?php
try {

  $init['access_level'] = 'auth'; // anon, auth, admin, global_admin
  $init['ajax'] = true;
  $init['application'] = 'www.axis.com';
  $init['cache_control'] = 'nocache';
  $init['debugging_mode'] = true;
  $init['display'] = true;
  $init['geo'] = false;
  $init['get_maxlength'] = 2048;
  $init['get_required'] = true;
  $init['https'] = true;
  $init['https_admin'] = true;
  $init['https_auth'] = true;
  $init['no_db_init'] = false;
  $init['output_buffering'] = true;
  $init['override_php_ini'] = false;
  $init['timer'] = true;
  $init['timer_start'] = true;
  require_once('lib/common/init.php');
  require_once('lib/common/Message.php');
  require_once('lib/common/Draws.php');
  require_once('lib/common/DrawItems.php');
  require_once('lib/common/DrawStatus.php');
  require_once('lib/common/DrawSignatureType.php');
  require_once('lib/common/DrawSignatureBlocks.php');
  require_once('lib/common/DrawSignatureBlocksConstructionLender.php');
  require_once('lib/common/DrawFileManagerFiles.php');
  require_once('lib/common/FileManagerFolder.php');
  require_once('lib/common/RetentionDraws.php');
  require_once('lib/common/RetentionItems.php'); 
  require_once('lib/common/Project.php'); 
  
  $message = Message::getInstance();
  /* @var $message Message */
  $message->reset();
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

  require_once('modules-draw-list-function.php');
  $timer->startTimer();
  $_SESSION['timer'] = $timer;
  // SESSION VARIABLES
  /* @var $session Session */
  $project_id = $session->getCurrentlySelectedProjectId();
  $project_name = $session->getCurrentlySelectedProjectName();
  $user_company_id = $session->getUserCompanyId();
  $user_id = $session->getUserId();
  $currentlyActiveContactId = $session->getCurrentlyActiveContactId();


  $db = DBI::getInstance($database);

  ob_start();

  // C.R.U.D. Pattern

  switch ($methodCall) {

    case 'filterDraw':
    $selectedStatusId = (string) $get->statusId;
    $drawTable= renderDrawListHtml($database,$project_id,$selectedStatusId);
    echo $drawTable;
    break;

    case 'getProjectRetainerValue':
    $projectRetainerRate = DrawItems::getProjectRetainerValue($database, $project_id);
    if($projectRetainerRate){
      echo 0;
    }else{
      echo 1;
    }
    break;

    case 'validateCurrentAppValue':
    try{
      $drawItemId = (int)$get->drawItemId;
      $drawItem = DrawItems::findById($database, $drawItemId);
      $scheduledValue = $drawItem['scheduled_value'];
      // To include the reallocations
      $realocation = $drawItem['realocation'];
      $scheduledValue = $scheduledValue +$realocation;
      echo $scheduledValue;
    } catch (Exception $e) {
      $db->rollback();
      $db->free_result();
      $errorNumber = 1;
    }
    break;


    case 'createDraw':
    $getDraftDrawItemCount = Draws::findDraftDrawIdUsingProjectId($database, $project_id);
    $getDraftRetentionItemCount = RetentionDraws::findDraftRetentionIdUsingProjectId($database, $project_id);
    if($getDraftDrawItemCount > 0 || $getDraftRetentionItemCount > 0){
      echo $getDraftDrawItemCount."~".$getDraftRetentionItemCount.'~1';
      break;
    }
    $getLastDrawItemId = Draws::findLastDrawIdUsingProjectId($database, $project_id);
    $createdDraw = Draws::createDraw($database, $project_id,$currentlyActiveContactId);
    $createdDrawApplicationId = DrawItems::createDrawItems($database, $project_id, $createdDraw);

    if ($getLastDrawItemId) {
      $drawId = $getLastDrawItemId;
      $curDrawId = $createdDraw;
      // $drawId = 1;
      // get all signature blocks
      $loadSignatureBlockOptions = new Input();
      $loadSignatureBlockOptions->forceLoadFlag = true;
      $getAllDrawSignatureBlockArr=DrawSignatureBlocks::loadAllDrawSignatureBlocks($database, $drawId, $loadSignatureBlockOptions);
      foreach($getAllDrawSignatureBlockArr as $signatureBlockId => $signatureBlock) {
        // $signatureBlockDetail = DrawSignatureBlocks::findById($database, $signatureBlockId);
        $signBlockConstructionLender = $signatureBlock->getSignatureBlockConstructionLender();
        $signatureBlockDetail = DrawSignatureBlocks::findById($database, $signatureBlockId);
        $signatureBlockDetail->convertPropertiesToData();
        $data = $signatureBlockDetail->getData();
        $data['id'] = Null;
        $data['draw_id'] = $curDrawId;
        // clone
        $signatureBlockClone = new DrawSignatureBlocks($database);
        $signatureBlockClone->setData($data);
        $signatureBlockClone->convertDataToProperties();
        $signBlock_id = $signatureBlockClone->save();

    //     if($signBlockConstructionLender){
    //       $sbClId = $signBlockConstructionLender->signature_block_construction_lender_id;
    //       $signBlockConstructionLender = DrawSignatureBlocksConstructionLender::findById($database, $sbClId);
    //       $signBlockConstructionLender->convertPropertiesToData();
    //       $dataCL = $signBlockConstructionLender->getData();
    //       $dataCL['id'] = Null;
    //       $dataCL['signature_block_id'] = $signBlock_id;
    //       // echo '<pre>';
    //       // print_r($signBlockConstructionLender);
    //       // clone
    //       $signatureBlockCLClone = new DrawSignatureBlocksConstructionLender($database);
    //       $signatureBlockCLClone->setData($dataCL);
    //       $signBlock_id = $signatureBlockCLClone->save();
    //     }
      }
    }
    echo $createdDrawApplicationId;
    break;

    case 'updateDrawThroughDate':
    $throughDate = (string)$get->throughDate;
    $drawId = (int)$get->drawId;
    $drawId = (int) $drawId;
    $drawDate = date('Y-m-d',strtotime($throughDate));
    $draws = Draws::findById($database, $drawId);
    $draws->convertPropertiesToData();
    $drawData = $draws->getData();
    $drawData['updated_by'] = $throughDate;
    $drawData['through_date'] = $drawDate;
    $draws->setData($drawData);
    $draws->save();
    break;

    case 'updateDrawInvoiceDate':
    $invoiceDate = (string)$get->invoiceDate;
    $drawId = (int)$get->drawId;
    $drawId = (int) $drawId;
    $drawDate = date('Y-m-d',strtotime($invoiceDate));
    $draws = Draws::findById($database, $drawId);
    $draws->convertPropertiesToData();
    $drawData = $draws->getData();
    $drawData['updated_by'] = $invoiceDate;
    $drawData['invoice_date'] = $drawDate;
    $draws->setData($drawData);
    $draws->save();
    break;

    // added nl2br function to html entites
    case 'updateDrawItem':
    $column = (string)$get->attributeSubGroup;
    $type = (string)$get->attributeType;
    $newValue = (string)$get->attributeValue;
    $drawItemId = (int)$get->drawItemId;
    $lineItemId = (int)$get->lineItemId;
    $drawId = (int) $get->drawId;
    $newValue = nl2br(htmlentities(trim($newValue)));
    $applicationNumber = DrawItems::updateDrawItem($database, $project_id, $drawItemId,$newValue,$lineItemId,$type,$column,$drawId);
    Draws::updateDrawData($database,$drawId,$currentlyActiveContactId,"","",$project_id);
    $createDrawTable= renderCreateDrawHtml($database,$project_id,$applicationNumber);
    echo $createDrawTable;
    break;

    case 'saveDrawAsDraft':
    $drawId = $_POST['drawId'];
    $arrCountOfDraftDraw = Draws::findDraftDrawCountUsingDrawId($database, $project_id, $drawId);
    $getCountOfDraftDraw = $arrCountOfDraftDraw['rowCount'];
    $getDraftDrawId = $arrCountOfDraftDraw['currentDraftDrawId'];
    $getCurrentDraftDrawAppId = $arrCountOfDraftDraw['currentDraftDrawAppId'];

    if(intVal($getCountOfDraftDraw) > 0){
      echo $getCountOfDraftDraw.'~'.$getDraftDrawId.'~'.$getCurrentDraftDrawAppId;
      break;
    }
    $drawStatus = $_POST['drawStatus'];
    if(isset($_POST['data'])){
      $drawItems = json_decode($_POST['data']);
      foreach ($drawItems as $key => $value) {
        $drawItemId = $value->drawItemId;
        if (substr($value->currentApp, 0, 1) == '-') {
          $currentApp = '-'.floatval(preg_replace('/[^\d.]/', '', $value->currentApp));//To remove $ and comma
        }else{
          $currentApp = floatval(preg_replace('/[^\d.]/', '', $value->currentApp));//To remove $ and comma
        }        
        $retainerRate = $value->retainerRate;
        $completedPercentage = $value->completedPercentage;
        if (substr($value->currentRetainerRate, 0, 1) == '-') {
          $currentRetainerRate = '-'.floatval(preg_replace('/[^\d.]/', '', $value->currentRetainerRate));
        }else{
          $currentRetainerRate = floatval(preg_replace('/[^\d.]/', '', $value->currentRetainerRate));
        }
        $narrative =$value->narrative;
        $drawItemData = DrawItems::findById($database, $drawItemId);
        $drawItemData->convertPropertiesToData();
        $data = $drawItemData->getData();
        $data['current_app'] = $currentApp;
        $data['completed_percent'] = $completedPercentage;
        $data['current_retainer_value'] = $currentRetainerRate;
        $data['narrative'] = $narrative;
        $drawItemData->setData($data);
        // $drawItemData->save();
      }
    }
    Draws::updateDrawData($database,$drawId,$currentlyActiveContactId,$drawStatus,"",$project_id);
    break;

    case 'updateScheduledValueInDraws':
    $gcBudgetLineItemId = (int)$get->gcBudgetLineItemId;
    $project_id = (int) $project_id;
    $scheduledValue = (float) $get->scheduledValue;
    DrawItems::saveOrUpdateScheduledValues($database,$project_id,$gcBudgetLineItemId,$scheduledValue);
    break;

    case 'deleteGcBudgetFromDraws':
    $gcBudgetLineItemId = (int)$get->gcBudgetLineItemId;
    $project_id = base64_decode($get->pID);
    $project_id = (int) $project_id;
    DrawItems::deleteGcBudgetLineItem($database,$project_id,$gcBudgetLineItemId);
    break;

    case 'updateChangeOrderInDraws':
    $changeOrderId = (int)$get->changeOrderId;
    $approved_date = date("Y-m-d", strtotime($get->approved_date));
    $project_id = (int) $project_id;

    // To get draft draw or draft retention invoice date
    $get_invoice_date = Draws::getDraftInvoiceDate($database, $project_id);
    $explode = explode("_",$get_invoice_date);
    $type = $explode[0];
    $draw_id = $explode[1];
    $invoice_date = date("Y-m-d", strtotime($explode[2]));
    
    if (($approved_date <= $invoice_date) && $type == 'draw' ) {
      $drawIdsArr = DrawItems::updateChangeOrder($database,$project_id,$changeOrderId);
      DrawItems::saveChangeOrder($database,$project_id,$changeOrderId,$drawIdsArr);
      DrawItems::deleteChangeOrder($database,$project_id,$changeOrderId);
      DrawItems::updateScheduledValueAgainstCostcode($database,$project_id);
    }

    if (($approved_date <= $invoice_date) && $type == 'retention') {
      $drawIdsArr = RetentionItems::updateChangeOrder($database,$project_id,$changeOrderId);
      echo "string";
      print_r($drawIdsArr);
      RetentionItems::saveChangeOrder($database,$project_id,$changeOrderId,$drawIdsArr);
      RetentionItems::deleteChangeOrder($database,$project_id,$changeOrderId);
      RetentionItems::updateScheduledValueAgainstCostcode($database,$project_id);
    }
    break;
    case 'DeleteDraw':
    try {
      $drawId = (int)$get->draw_id;
      $getArrDrawItems = DrawItems::getDrawItemsByDrawId($database, $drawId);
      foreach($getArrDrawItems as $drawItemId => $drawItem) {
        $drawItemId = $drawItem['id'];
        $drawItemGet = DrawItems::findById($database, $drawItemId);
        $drawItemGet->delete();
      }
      $getDraw = Draws::findById($database, $drawId);
      $getDraw->delete();
      // $getDraw->convertPropertiesToData();
      // $data = $getDraw->getData();
      // $data['is_deleted_flag'] = 'Y';
      // $getDraw->setData($data);
      // $getDraw->save();
      $errorNumber = 0;
    } catch (Exception $e) {
      $db->rollback();
      $db->free_result();
      $errorNumber = 1;
    }

    break;

    case 'DeleteRetention':
    try {
      $retId = (int)$get->ret_id;
      $getArrRetentionItems = RetentionItems::getRetentionItemsByRetentionId($database, $retId);
      foreach($getArrRetentionItems as $retentionItemId => $retentionItem) {
        $retentionItemId = $retentionItem['id'];
        $retentionGet = RetentionItems::findById($database,$retentionItemId);
        $retentionGet->delete();
      }
      $getDraw = RetentionDraws::findById($database, $retId);
      $getDraw->delete();
      // $getDraw->convertPropertiesToData();
      // $data = $getDraw->getData();
      // $data['is_deleted_flag'] = 'Y';
      // $getDraw->setData($data);
      // $getDraw->save();
      $errorNumber = 0;
    } catch (Exception $e) {
      $db->rollback();
      $db->free_result();
      $errorNumber = 1;
    }

    break;

    case 'PostDrawToDraft':
    try {
      echo $drawId = (int)$get->draw_id;
      $getDraw = Draws::findById($database, $drawId);
      $getDrawPre = $getDraw;
      $getDraw->convertPropertiesToData();
      $data = $getDraw->getData();
      $data['status'] = 1;
      $getDraw->setData($data);
      $getDraw->save();
      DrawItems::addGcBudgetLineItems($database, $project_id, $drawId);
      DrawItems::deleteBudgetLineItem($database, $project_id, $drawId);
      DrawItems::addChangeOrderLineItems($database, $project_id, $drawId);
      DrawItems::deleteChangeOrderLineItems($database, $project_id, $drawId);
      DrawItems::updateGcBudgetLineItems($database, $project_id, $drawId);
      DrawItems::updateChangeOrderLineItems($database, $project_id, $drawId);
      // $getDraw = Draws::findById($database, $drawId);
      $change = false;
      if($getDrawPre->status == 2 && $change) {
        $drawStatus = 1;
        $drawFileMangerFileOptions = new Input();
        $drawFileMangerFileOptions->forceLoadFlag = true;
        $getDrawFmF = DrawFileManagerFiles::loadDrawFilesByDrawId($database, $drawId, $drawFileMangerFileOptions);
        $file_manager_folder_id = $getDrawFmF->file_manager_folder_id;
        $getFileManagerFolder = FileManagerFolder::findById($database, $file_manager_folder_id);
        if(isset($getFileManagerFolder) && !empty($getFileManagerFolder)){
          /* Create folder path*/
          $arrVirtualPath = array(1 => "In Draft", 2 => "Post Draw");
          $curVirtualPath = $arrVirtualPath[$drawStatus];
          $application_number = $getDrawPre->application_number;
          $virtual_file_path = '/Draws/'.$curVirtualPath.'/Draw #'. $application_number.'/';

          $fileManagerFolderPath = $getFileManagerFolder->virtual_file_path;
          $getFileManagerFolder->convertPropertiesToData();
          $data = $getFileManagerFolder->getData();
          $data['virtual_file_path'] = $virtual_file_path;
          $getFileManagerFolder->setData($data);
          $getFileManagerFolder->convertDataToProperties();
          $getFileManagerFolder->save();
        }
      }
      $errorNumber = 0;
    } catch (Exception $e) {
      $db->rollback();
      $db->free_result();
      $errorNumber = 1;
    }
    break;

    case 'postDraw':
    try {
      $drawId = $_POST['drawId'];
      $drawStatus = $_POST['drawStatus'];
      $postedAt = date('Y-m-d h:i:s a', time());
      $getDraw = Draws::findById($database, $drawId);
      Draws::updateDrawData($database,$drawId,$currentlyActiveContactId,$drawStatus,$postedAt,$project_id);
      $cor_type = Project::CORAboveOrBelow($database,$project_id);
      $cortype = ($cor_type == 2) ? 'A' : 'B';
      DrawItems::updateReallocationStatus($database,$drawId,$project_id,$cortype);
      /*sleep(2);
      DrawItems::deleteATLOrBTLforFirstDraw($database,$drawId,$cor_type);*/
      /* change the folder draft to post draw*/
      $change = false;
      if($getDraw->status == 1 && $change) {
        $drawFileMangerFileOptions = new Input();
        $drawFileMangerFileOptions->forceLoadFlag = true;
        $getDrawFmF = DrawFileManagerFiles::loadDrawFilesByDrawId($database, $drawId, $drawFileMangerFileOptions);
        $file_manager_folder_id = $getDrawFmF->file_manager_folder_id;
        $getFileManagerFolder = FileManagerFolder::findById($database, $file_manager_folder_id);
        if(isset($getFileManagerFolder) && !empty($getFileManagerFolder)){
          /* Create folder path*/
          $arrVirtualPath = array(1 => "In Draft", 2 => "Post Draw");
          $curVirtualPath = $arrVirtualPath[$drawStatus];
          $application_number = $getDraw->application_number;
          $virtual_file_path = '/Draws/'.$curVirtualPath.'/Draw #'. $application_number.'/';

          $fileManagerFolderPath = $getFileManagerFolder->virtual_file_path;
          $getFileManagerFolder->convertPropertiesToData();
          $data = $getFileManagerFolder->getData();
          $data['virtual_file_path'] = $virtual_file_path;
          $getFileManagerFolder->setData($data);
          $getFileManagerFolder->convertDataToProperties();
          $getFileManagerFolder->save();
        }
      }
      $errorNumber = 0;
    } catch (Exception $e) {
      $db->rollback();
      $db->free_result();
      $errorNumber = 1;
    }
    break;
    case 'postRetentionDraw':
      $retentionId = $_GET['retentionId'];
      $retentionDrawStatus = $_GET['retentionDrawStatus'];
      $postedAt = date('Y-m-d h:i:s a', time());
      RetentionDraws::updateRetentionData($database,$retentionId,$currentlyActiveContactId,$retentionDrawStatus,$postedAt,$projectId);
    break;
    case 'drawActionType':

      $loadarrDrawActionOptionRows = new Input();
      $loadarrDrawActionOptionRows->forceLoadFlag = true;
      $loadarrDrawActionOptionRows->arrOrderByAttributes = array(
        'dato.`id`' => 'ASC'
      );

      $draw_action_type_id = Data::parseInt($get->draw_action_type_id);

      $arrDrawActionTypeOptions = DrawActionTypeOptions::loadAllDrawActionTypeOptionsByActId($database, $draw_action_type_id, $loadarrDrawActionOptionRows);
      $options = '<option value="">Select Option</option>';
      foreach($arrDrawActionTypeOptions as $actionTypeOptionId => $actioTypeOption){
        $draw_action_type_option_id = $actioTypeOption->draw_action_type_option_id;
        $draw_action_type_id = $actioTypeOption->draw_action_type_id;
        $option_name = $actioTypeOption->option_name;
        $actionTypeValueOption = array();
        $actionTypeValueOption['draw_action_type_option_id'] = $draw_action_type_option_id;
        $actionTypeValueOptionJson = implode('--', $actionTypeValueOption);
        $options .= '<option value="'.$actionTypeValueOptionJson.'">'.$option_name.'</option>';
      }
      echo $options;
     
    break;

    case 'createRetentionDraw':
    $getDraftRetentionItemCount = RetentionDraws::findDraftRetentionIdUsingProjectId($database, $project_id);
    $getDraftDrawItemCount = Draws::findDraftDrawIdUsingProjectId($database, $project_id);
    if($getDraftRetentionItemCount > 0 || $getDraftDrawItemCount >0){
      echo $getDraftRetentionItemCount."~".$getDraftDrawItemCount.'~1';
      break;
    }
    $LastDrawItemId = Draws::findLastDrawIdUsingProjectId($database, $project_id);
    $LastDrawApplicationo = Draws::findLastDrawIdUsingProjectId($database, $project_id,'application_number');
    $RetentionId = RetentionDraws::createRetention($database, $project_id,$currentlyActiveContactId,$LastDrawItemId);
    $createdRetentionApplicationId = RetentionItems::createRetentionItems($database, $project_id, $RetentionId,$LastDrawItemId,$LastDrawApplicationo);
    echo $createdRetentionApplicationId;
    break;

    case 'validateCurrentRetainerValue':
    try{
      $retentionItemId = (int)$get->retentionItemId;
      $retentionItem = RetentionItems::findById($database, $retentionItemId);
      $current_retainage = $retentionItem['current_retainage'];
      echo $current_retainage;
    } catch (Exception $e) {
      $db->rollback();
      $db->free_result();
      $errorNumber = 1;
    }
    break;

    case 'updateRetentionItem':
    $column = (string)$get->attributeSubGroup;
    $type = (string)$get->attributeType;
    $newValue = (string)$get->attributeValue;
    $retentionItemId = (int)$get->retentionItemId;
    $lineItemId = (int)$get->lineItemId;
    $RetentionId = (int) $get->RetentionId;
    $curRetainage  = (string)$get->curRetainage;

    $applicationNumber = RetentionItems::updateRetentionItem($database, $project_id, $retentionItemId,$newValue,$lineItemId,$type,$column,$RetentionId,$curRetainage);
    RetentionDraws::updateRetentionData($database,$RetentionId,$currentlyActiveContactId,"","",$project_id);
    $createDrawTable= renderCreateRetentionHtml($database,$project_id,$applicationNumber);
    echo $createDrawTable;
    break;

    case 'postReallocation':
      $drawId = (int)$get->drawId;
      $application_number = DrawItems::postReallocation($database, $drawId,$project_id);
      $createDrawTable= renderCreateDrawHtml($database,$project_id,$application_number);
      echo $createDrawTable;
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
