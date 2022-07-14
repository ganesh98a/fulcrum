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
require_once('lib/common/Mail.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Mail.php');
require_once('lib/common/Contact.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfPhantomJS.php');


require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('punch_card_functions.php');

$timer->startTimer();
$_SESSION['timer'] = $timer;
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

    case 'CreatebuildingDialog':    // Dialog popup for create dialog


        $crudOperation = 'load';
        $errorNumber = 0;
        $errorMessage = '';
        $primaryKeyAsString = '';
        $htmlContent = '';
        try {
            // Ajax Handler Inputs
            require('code-generator/ajax-get-inputs.php');
                $htmlContent = buildCreateBuildingsDialog($database, $user_company_id, $project_id, $currentlyActiveContactId);

        } catch(Exception $e) {
            $db->rollback();
            $db->free_result();
            $errorNumber = 1;
        }

        $arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
        if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
            $errorNumber = 1;
            $errorMessage = join('<br>', $arrErrorMessages);
        }

        $jsonFlag = false;
        if (isset($responseDataType) && ($responseDataType == 'json')) {
            require('code-generator/json-response.php');
        } elseif (isset($responseDataType) && ($responseDataType == 'html')) {
            $output = $htmlContent;
        }

        if ($jsonFlag) {
            // Send HTTP Content-Type header to alert client of JSON output
            header('Content-Type: application/json');
        }
        echo $output;
    break;

    case 'Insertbuilding':

      $building_name=addslashes($get->building_name);
      $location=addslashes($get->location);
      $description=addslashes($get->description);
      $retdata = InsertBuildingdata($building_name,$location,$description,$project_id);
       // Send HTTP Content-Type header to alert client of JSON output
      header('Content-Type: application/json');
      echo json_encode($retdata);

      break;

    case 'Insertrooms':

      $building_id = addslashes($get->building_data);
      $unit = $get->unit;
      $arr_unit=json_decode($unit,true);
     
      foreach ($arr_unit as $key => $uni_value) {
       
       $unit_name =$uni_value[0];
        if($unit_name !="")
        {
        $retdata = InsertRoomsdata($building_id,$unit_name,$project_id);
        }
      }
      echo '1';
      break;

       case 'updateUnitName':

      $unit_id = $get->unit_id;
      $unit_name = $get->unit_name;
      $retdata = updateunitname($unit_id,$unit_name);
       
      echo '1';
      break;

      case 'deleteBuildingandunit':

      $id = $get->id;
      $type = $get->type;
      if($type =='room')
      {
          deleteunit($database,$id);
      }else
      {
          deletebuilding($database,$id);
      }

      break;

      case "Listviewupdate":
      $userCanManagePunch = checkPermissionForAllModuleAndRole($database,'manage_punch_card');
      // Generate a log table of Transmittal datas and assign to variable
      $buildRoomTable= renderBuildingRoomsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch);
      $buildDefectTable= renderDefectsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch);
       header('Content-Type: application/json');
       $output =array('Roomsdata' => $buildRoomTable, 'Defectdata' => $buildDefectTable);
        echo json_encode($output);

      break;

    case "defectsDialog" :
        $crudOperation = 'load';
        $errorNumber = 0;
        $errorMessage = '';
        $primaryKeyAsString = '';
        $htmlContent = '';
        try {
            // Ajax Handler Inputs
            require('code-generator/ajax-get-inputs.php');
                $htmlContent = loadDefectDialog($project_id);

        } catch(Exception $e) {
            $db->rollback();
            $db->free_result();
            $errorNumber = 1;
        }

        $arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
        if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
            $errorNumber = 1;
            $errorMessage = join('<br>', $arrErrorMessages);
        }

        $jsonFlag = false;
        if (isset($responseDataType) && ($responseDataType == 'json')) {
            require('code-generator/json-response.php');
        } elseif (isset($responseDataType) && ($responseDataType == 'html')) {
            $output = $htmlContent;
        }

        if ($jsonFlag) {
            // Send HTTP Content-Type header to alert client of JSON output
            header('Content-Type: application/json');
        }
        echo $output;
   
    break;

    case "EditdefectsDialog":
        $defect_id = $get->defect_id;
        $defDialog = loadEditDefectDialog($project_id,$defect_id);
        echo $defDialog;
    break;

     case "InsertpunchDefects" :

      $defect = $get->defect;
      $arr_defect=json_decode($defect,true);
           
      foreach ($arr_defect as $key => $defect_value) {
       
       $defect_name =$defect_value[0];
        if($defect_name !="")
        {
            $retdata = InsertpunchDefects($defect_name,$user_company_id);
        }
      }
      echo '1';
    break;

    case "UpdatepunchDefects":
      $defect = $get->defect;
      $def_id = addslashes($get->id);
      $retdata = UpdatepunchDefects($defect,$def_id,$user_company_id);
    break;

    case "showEditBuilding":
        $building_id = $get->building_id;
        $buildDialog = loadshowEditBuilding($project_id,$building_id);
        echo $buildDialog;

    break;

    case "updatebuilding":
      $building_name=addslashes($get->building_name);
      $location=addslashes($get->location);
      $description=addslashes($get->description);
      $build_id = $get->build_id;
      $retdata = UpdateBuildingdata($building_name,$location,$description,$project_id,$build_id);
       // Send HTTP Content-Type header to alert client of JSON output
      header('Content-Type: application/json');
      echo json_encode($retdata);

    break;

    case "showEditRooms":
        $room_id = $get->room_id;
        $roomDialog = loadshowEditRooms($project_id,$room_id);
        echo $roomDialog;

    break;

    case "updateRoomData":
      $room_name = addslashes($get->room_name);
      $description = addslashes($get->description);
      $room_id = $get->room_id;
      $building_id = $get->building_id;
      
      $retdata = updateRoomDatas($room_id,$room_name,$description,$building_id);
    break;

    case "DeleteDefects":

      $defId = $get->id;
      $retdata = deletepunchDefects($database,$defId);
      echo $retdata;
    break;


    case "updateimportProjectonbuildingunit":
    
    $changeprjid = $get->changeprjid;
    $resdata= buildingandunitbasedonProject($database,$changeprjid);
    echo $resdata;
    
    break;

    case "dialogUploadOrCreatebuilding":
     $importarrunit = $get->importarrunit;
    
      $defDialog = DialogForNewBuildorExisting($project_id,$importarrunit);
      echo $defDialog;

    break;

    case "importItems":
    
    $importarr = $get->importarr;
    $importnew = json_decode($importarr,true);
    $item = $get->item;
    if($item =="unit")
    {
      $arrimport =$importnew;
    }else
    {
      $arrimport =$importnew[0];
    }

 
   foreach ($arrimport as $key => $importnw) {
    
   
    $building_id= checkbuildexistornot($database,$key,$project_id);
    if($building_id =='0')
    {
      //To import building
       $db = DBI::getInstance($database); 
       $buildquery ="insert into punch_building_data (`project_id`, `building_name`, `location`)SELECT $project_id ,building_name, location from punch_building_data where id ='$key'";
       $db->execute($buildquery);
       $building_id = $db->insertId; 
       $db->free_result();

    }
   
    foreach ($importnw as $ukey => $uvalue) {

       $resunit= checkunitexistornot($database,$uvalue,$project_id,$building_id);
       if($resunit =='0')
       {
        //To import units
         $db = DBI::getInstance($database); 
         $unitquery ="insert into punch_room_data (`project_id`, `building_id`, `room_name`, `description`)SELECT $project_id ,$building_id, room_name, description from punch_room_data where id ='$uvalue'";
        $db->execute($unitquery);
        $unit_id = $db->insertId; 
        $db->free_result();
    }
    }


   }
    
    break;

    case "importbuildingUnitDialog":

     $crudOperation = 'load';
        $errorNumber = 0;
        $errorMessage = '';
        $primaryKeyAsString = '';
        $htmlContent = '';
        try {
            // Ajax Handler Inputs
            require('code-generator/ajax-get-inputs.php');
                $htmlContent = importbuildandunitdata($database,$project_id,$user_company_id,$currentlyActiveContactId);
                 // buildCreateBuildingsDialog($database, $user_company_id, $project_id, $currentlyActiveContactId);

        } catch(Exception $e) {
            $db->rollback();
            $db->free_result();
            $errorNumber = 1;
        }

        $arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
        if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
            $errorNumber = 1;
            $errorMessage = join('<br>', $arrErrorMessages);
        }

        $jsonFlag = false;
        if (isset($responseDataType) && ($responseDataType == 'json')) {
            require('code-generator/json-response.php');
        } elseif (isset($responseDataType) && ($responseDataType == 'html')) {
            $output = $htmlContent;
        }

        if ($jsonFlag) {
            // Send HTTP Content-Type header to alert client of JSON output
            header('Content-Type: application/json');
        }
        echo $output;
    
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
