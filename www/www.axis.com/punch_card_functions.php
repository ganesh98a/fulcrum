<?php
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Format.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/User.php');
require_once('lib/common/Mail.php');
require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('transmittal-functions.php');

$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

/**
* Display the Buildings Grid
* @param project id
* @return html
*/
function renderBuildingRoomsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch)
{	
	$buildingTableTbody = '';
	$incre_id=1;
	$db = DBI::getInstance($database);
	$query = "SELECT pb.`id` as building_id, pb.`project_id`, pb.`building_name`, pb.`location`,pb.`description` as build_description, pr.*
	 from punch_room_data as pr inner join punch_building_data as pb on pr.building_id = pb.id where pr.project_id='$project_id' order by pb.building_name  ";
	$db->execute($query);
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$build_show="";
	$ic='1';
	if($records)
	{
	foreach($records as $row)
	{
		$building_id      = $row['building_id'];
		$room_name 	= $row['room_name'];
		$description   	= $row['build_description'];
		$building_name	= $row['building_name'];
		$location   	= $row['location'];
		$room_id   	= $row['id'];

		//To check whether the Building mapped  in punch_item or not
		$buildingResult=checkfieldexistInpunchListornot('location_id',$building_id);
		if($buildingResult =="1")
		{
			$funforbuilddelete ="existpunchwarn('build','$building_id');";
		}else
		{
			$funforbuilddelete ="Delpunchconfirm('build','$building_id');";
		}
		//End 
		//To check whether the Unit mapped  in punch_item or not
		$unitResult=checkfieldexistInpunchListornot('room_id',$room_id);
		if($unitResult =="1")
		{
			$funforunitdelete ="existpunchwarn('room','$room_id');";
		}else
		{
			$funforunitdelete ="Delpunchconfirm('room','$room_id');";
		}
		//End 

		if($build_show != $building_id)
		{
			 	$build_show=$building_id;
				$head_insert='1';
		}
		else
		{
				$head_insert='0';
		}

		$building_name = str_replace('\'', '&apos;',$building_name);
		if($head_insert == "1")
		{
			$buildingTableTbody .= <<<END_DELAYS_TABLE_TBODY
			<tr style="cursor:pointer;"  class="purStyle">
			<td onclick="showEditBuilding('$building_id')"><input type="hidden" id="manage-unit-record--punch_room_data--building_name--$building_id" value='$building_name'><b class="headsle">$building_name</b></td>
			<td id="manage-room_data-record--" onclick="showEditBuilding('$building_id')">
			<div width="100%" class="breakbuild_content" style="height:100%;" data-toggle="tooltip" title="$description" data-original-title="$description">$description</div>
			</td>
			<td class="textAlignCenter" id="manage-room_data-record--" onclick="showEditBuilding('$building_id')">$location</td>
			<td class="textAlignCenter" id="manage-room_data-record--" ><span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="$funforbuilddelete" title="Delete Unit">&nbsp;</span> </td>

			</tr>
END_DELAYS_TABLE_TBODY;
		}
//onclick="showEditRooms('$room_id')"
		$room_name = str_replace('\'', '&apos;',$room_name);
   		$buildingTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-room_data-record--" class="row_$room_id list-row " style="cursor:pointer;$code_insert_header" >
			
			<td colspan="3">
			<span id="prime-text-$room_id" class="unit_name--$room_id  unit-text" style="display:block;align:center;">$room_name</span>

			<input id="manage-unit-record--punch_room_data--room_name--$room_id" class=" unit-edit" type="text" value='$room_name'  onchange="unit_update(this.id,this.value, '$room_id');"  style="display:none;">
			</td>


			
			<td class="textAlignCenter" id="manage-room_data-record--" ><span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="$funforunitdelete" title="Delete Unit">&nbsp;</span> </td>
			</tr>

END_DELAYS_TABLE_TBODY;
		$incre_id++;
		}
	}else
	{
		$buildingTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr ><td colspan='4'>No Data Available</td></tr>
END_DELAYS_TABLE_TBODY;

	}
	$htmlContent = <<<END_HTML_CONTENT
<table id="buildingtblTabularData" class="potential-grid table-suborder-view sub_selectST" border="$border" cellpadding="5" style="border-collapse:collapse;" width="80%">
	<thead>
		<tr class="permissionTableMainHeader">
		<th width="20%">
		<div style="margin:0 auto;width: 50%;overflow: hidden;"><span style="float:left;">Unit Name 
		</span>
		<span id="entypo-edit-icon" class="entypo-click" style="display:block;float:left;margin-left:10px;" onclick="allowToUserEditunits(true);">
		<img src="images/edit-icon.png"></img>

		</span>
		<span  id="entypo-lock-icon" class="entypo-click" style="display:none;float:left;margin-left:10px;" onclick="allowToUserEditunits(false);">
		<span class="entypo-lock"></span>
		</span>
		</div>
		</th>
	
		<th width="20%" class="">Description</th>
		<th width="20%" class="textAlignCenter ">Building Location</th>
		<th width="5%" class="">Action</th>
		</tr>
	</thead>
	<tbody class="">
		$buildingTableTbody
	</tbody>
</table>

END_HTML_CONTENT;


	return $htmlContent;
}

/**
* Display the Buildings Grid
* @param project id
* @return html
*/
function renderDefectsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch)
{	
	$defectTableTbody = '';
	$incre_id=1;
	$db = DBI::getInstance($database);
	$query = "SELECT * from punch_defects where user_company_id = '$user_company_id' order by id  ";
	$db->execute($query);
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$ic='1';
	foreach($records as $row)
	{
		
		$defect_name 	= $row['defect_name'];
		$id   	= $row['id'];
		//To check whether the defect item present in punch_item or not
		$defResult=checkfieldexistInpunchListornot('description_id',$id);
		if($defResult =="1")
		{
			$funfordelete ="existDefectwarn('$id', $userCanManagePunch);";
		}else
		{
			$funfordelete ="DelDefectconfirm('$id', $userCanManagePunch);";
		}

		

   		$defectTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-room_data-record--" class="row_$room_id list-row" style="$code_insert_header"  >
			<td class="textAlignCenter" id="record_container--manage-room_data-record--" onclick="showDefectEditdialog('$id', $userCanManagePunch)">$incre_id</td>
			<td class="textAlignLeft" id="record_container--manage-room_data-record--" onclick="showDefectEditdialog('$id', $userCanManagePunch)">$defect_name</td>

			<td class="textAlignCenter"><span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="$funfordelete" title="Delete Defect">&nbsp;</span></td>

		</tr>

END_DELAYS_TABLE_TBODY;
		$incre_id++;
		}


// END_HTML_CONTENT;
			$htmlContent = <<<END_HTML_CONTENT
<table id="Building_data-record" class="content cell-border dealy-grid custom_delay_padding custom_table_alignment_delay" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		<th class="textAlignCenter">#</th>
		<th class="textAlignLeft">Defect Name</th>
		<th class="textAlignCenter">Action</th>
		</tr>
END_HTML_CONTENT;

$htmlContent .= <<<END_HTML_CONTENT
	</thead>
	<tbody class="altColors">
		$defectTableTbody
	</tbody>
</table>


END_HTML_CONTENT;


	return $htmlContent;
}

/**
* Dialog for Building 
* @param $database
* @param $user_company_id
* @param $project_id
* @param $currently_active_contact_id
* @param $dummyId
* @param $requestForInformationDraft
* @return html
*/

function buildCreateBuildingsDialog($database, $user_company_id, $project_id, $currently_active_contact_id, $dummyId=null)
{
	
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}
	$userTypes = loadBuildingsdata($project_id);

	$userTypes = array('' => 'Select') + $userTypes;
	$js = 'class="target moduleRFI_dropdown4 required"';

	$prependedOption = '<option value="">Select a Building</option>';
	$ddlbuildingListId = "building_data";
	$ddlbuildingList = PageComponents::dropDownList($ddlbuildingListId, $userTypes, '', null, $js, null);

	$htmlContent = <<<END_HTML_CONTENT

	<form name="formCreatebuilding" id="formCreatebuilding" >
	<div id="record_creation_form_container--create-punch-record--">
		<!--<div class="RFI_table_create"> -->
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody>
				
				<tr>
					<td width="70%" class="RFI_table_header2" colspan="3">Building 
					</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif required" colspan="3">
					$ddlbuildingList <span id="show_building" class="entypo entypo-click entypo-plus-circled"  style="margin-left:7px" ></span>
					</td>
				</tr>

				<tr>
					<td  class="RFI_table_header2 add_build"  style="display:none;" colspan="3">Building Name</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif add_build" colspan="3" style="display:none;">
					<input type="text" class="RFI_table2" id="building_name" value=""/>
					</td>
				</tr>

				<tr>
					<td  class="RFI_table_header2 add_build" colspan="3" style="display:none;">Location</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif add_build " colspan="3" style="display:none;">
					<input type="text" class="RFI_table2" id="location" value=""/>
					
					</td>
				</tr>

				<tr>
					<td  class="RFI_table_header2 add_build" colspan="3" style="display:none;">Description</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif required add_build" colspan="3" style="display:none;">
					<p><textarea class="RFI_table2 required target" id="description"></textarea></p>
					<input onclick="submitbuildingdata(null);" value="Create Building" style="margin-bottom:10px;margin-top:10px;" type="button">
					<input onclick="closebuilding();" value="Cancel Building" style="margin-bottom:10px;margin-top:10px;" type="button">
					</td>
				</tr>

				<tr>
					<td class="RFI_table_header2" colspan="3">Unit</td>
				</tr>
				<tr>
					<td class="RFI_table2_content" colspan="3">
					<div id="excelTable"></div>
				</td></tr>

				
				
			</tbody>
		   </table>
		<input id="unitsub" onclick="submitRoomdata(null);" value="Create Unit" style="margin-bottom:5px;margin-top:5px;display:none" type="button">	
		
	</div>
</form>

END_HTML_CONTENT;

	return $htmlContent;
}

//TO  create defects dialog
function loadDefectDialog($project_id)
{
	$modalContent=<<<modalContent
    
	<div class="tableview" $style>
	<table class="UserViews" width="100%" cellpadding="10" cellspacing="10">
	<thead>
	<tr>
	<td class="RFI_table_header2">Defect Name</td></tr>
	<tr><td class="RFI_table2_content">
	<div id="excelTable"></div>
	</td></tr>
	</thead>
	</table>
	</div>
modalContent;
return $modalContent;
}


//To load edit room dialog
function loadshowEditRooms($project_id,$room_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from  punch_room_data where id='$room_id'";

        $db->execute($query);
        $row= $db->fetch();
        $building_id =$row['building_id'];
        $room_name = $row['room_name'];
        $description = $row['description']; 
        $db->free_result();

    $userTypes = loadBuildingsdata($project_id);

	$userTypes = array('' => 'Select') + $userTypes;
	$js = 'class="target moduleRFI_dropdown4 required"';

	$prependedOption = '<option value="">Select a Building</option>';
	$ddlbuildingListId = "building_data";
	$ddlbuildingList = PageComponents::dropDownList($ddlbuildingListId, $userTypes, $building_id, null, $js, null);

	$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="punchmodalClose();">&times;</span>
      <h3>Edit Unit</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" $style>
     <table class="UserViews" width="100%" cellpadding="10" cellspacing="10">
     <tbody>
     <tr>
     <td width="70%" class="RFI_table_header2" colspan="3">Select Building 
     </td>
     </tr>
     <tr>
     <td class="RFI_table2_content font_serif required" colspan="3">
     $ddlbuildingList 
     </td>
     </tr>

     <tr>
     <td class="RFI_table_header2" colspan="3">Unit Name</td>
     </tr>
     <tr>
     <td class="RFI_table2_content font_serif required" colspan="3">
     <input type="text" class="RFI_table2 required" id="room_name" value="$room_name"/>
     </td>
     </tr>

     <tr>
     <td width="70%" class="RFI_table_header2" colspan="3">Description</td>
     </tr>
     <tr>
     <td class="RFI_table2_content font_serif required" colspan="3">
     <p><textarea class="RFI_table2 required target" id="description">$description</textarea></p>
     </td>
     </tr>
     </tbody>
     </table>
     </div>
    </div>
    <div class="modal-footer">
    <table width="100%"><tr><td align="right">
     	   <button class="punchbtnClose" onclick="updateRoomData($room_id);">Edit Unit</button>
    	   <button class="punchbtnClose" onclick="punchmodalClose();">Close</button>
    	   </td></tr>
    	   </table>
    </div>
  </div>
modalContent;
echo $modalContent;

}
//To load edit Building dialog
function loadshowEditBuilding($project_id,$building_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from  punch_building_data where id='$building_id'";

        $db->execute($query);
        $row= $db->fetch();
        $building_name = $row['building_name'];
        $location = $row['location']; 
        $description = $row['description']; 
        $db->free_result();
        $building_name = str_replace('\'', '&apos;',$building_name);

	$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="punchmodalClose();">&times;</span>
      <h3>Edit Building</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" $style>
     <table class="UserViews" width="100%" cellpadding="10" cellspacing="10">
     <tbody>
     <tr>
     <td  class="RFI_table_header2 add_build" colspan="3">Building Name</td>
     </tr>

     <tr>
     <td class="RFI_table2_content font_serif add_build">
     <input type="text" class="RFI_table2" id="building_name" value='$building_name'/>
     </td>
     </tr>

     <tr>
     <td  class="RFI_table_header2 add_build" >Location</td>
     </tr>
     <tr>
     <td class="RFI_table2_content font_serif add_build ">
     <input type="text" class="RFI_table2" id="location" value="$location"/>
     </td>
     </tr>

     <tr>
     <td  class="RFI_table_header2 add_build" colspan="3" >Description</td>
     </tr>
     <tr>
     <td class="RFI_table2_content font_serif required add_build" colspan="3" >
     <p><textarea class="RFI_table2 required target" id="description">$description</textarea></p>
     </td></tr>


     </tbody>
     </table>
     </div>
    </div>
    <div class="modal-footer">
    <table width="100%"><tr><td align="right">
     	   <button class="punchbtnClose" onclick="updatebuildingdata($building_id);">Edit Building</button>
    	   <button class="punchbtnClose" onclick="punchmodalClose();">Close</button>
    	   </td></tr>
    	   </table>
    </div>
  </div>
modalContent;
echo $modalContent;

}

//Dialog for creation of new or existing build
function DialogForNewBuildorExisting($project_id,$importarrunit)
{
	$userTypes = loadBuildingsdata($project_id);

	$userTypes = array('' => 'Select') + $userTypes;
	$js = 'class="target moduleRFI_dropdown4 required"';

	$prependedOption = '<option value="">Select a Building</option>';
	$ddlbuildingListId = "building_data";
	$ddlbuildingList = PageComponents::dropDownList($ddlbuildingListId, $userTypes, '', null, $js, null);

	$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="impmodalClose();">&times;</span>
      <h3>Some of units is not associated with Building</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" $style>
     <table class="UserViews" width="100%" cellpadding="10" cellspacing="10">
     <tr>
     <td width="40%">Select Building</td>
     <td width="60%">$ddlbuildingList
     <span id="show_building" class="entypo entypo-click entypo-plus-circled"  style="margin-left:7px" ></span></td>
     </tr>     
     <tr>
     <td width="40%"><div style="display:none;" class="add_build">Add New Building Name</div></td>
     <td width="60%"><div style="display:none;" class="add_build"><input style="width:88%;" type="text" class=" add_build" id="building_name" value=""/></div></td>
     </tr>
     <tr> 
     <td width="40%"><div style="display:none;" class="add_build">Location</div></td>
     <td width="60%"><div style="display:none;" class="add_build"><input type="text" style="width:88%;"  class=" add_build" id="location" value=""/></div></td>
     </tr>
     </table>


     </div>
    </div>
    <div class="modal-footer" style="padding-top: 25px;">
    <table width="100%"><tr><td align="right" width="70%">           
   		   <button style="display:none;" class="punchbtnClose add_build" onclick=submitbuildingdata(null);>Add Building</button>   		   
   		   </td>
   		   <td align="right" width="30%">
     	   <button class="punchbtnClose" onclick=allunitimp('$importarrunit');>Upload unit</button>
    	   <button class="punchbtnClose" onclick="impmodalClose();">Close</button>
    	   </td></tr>
    	   </table>
    </div>
  </div>
modalContent;
echo $modalContent;

}

//To load edit defect dialog
function loadEditDefectDialog($project_id,$defect_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from  punch_defects where id='$defect_id'";

        $db->execute($query);
        $row= $db->fetch();
        $defect_name = $row['defect_name']; 
        $db->free_result();
        $defect_name = str_replace('\'', '&apos;',$defect_name);

	$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="punchmodalClose();">&times;</span>
      <h3>Edit Defect</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" $style>
     <table class="UserViews" width="100%" cellpadding="10" cellspacing="10">
     <thead>
     <tr>
     <td>Defect Name</td>
     <td><input type="text" id="defect" name="defect" class="" value='$defect_name' style="width:98%"></td>
     </tr>
     </thead>
     </table>
     </div>
    </div>
    <div class="modal-footer">
    <table width="100%"><tr><td align="right">
     	   <button class="punchbtnClose" onclick="DefectEdit($defect_id);">Edit Defect</button>
    	   <button class="punchbtnClose" onclick="punchmodalClose();">Close</button>
    	   </td></tr>
    	   </table>
    </div>
  </div>
modalContent;
echo $modalContent;

}

//Import building and budget
function importbuildandunitdata($database,$project_id,$user_company_id,$currentlyActiveContactId)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT p.* FROM `projects` p WHERE p.`user_company_id` = ? AND p.`id` <> ?
	ORDER BY p.`project_name` ASC";
	$arrValues = array($user_company_id, $project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrProjectOptions = array();
	while ($row = $db->fetch()) {
		$ddlID =  $row['id'];
		$ddlDisplay = $row['project_name'];
		$arrProjectOptions[$ddlID] = $ddlDisplay;
	}
	$db->free_result();


			$ddlImportprjSources = '<select id="projectList" onchange="updateProjectbasedImports();">
						<option value="0">Please Select A Project</option>';
						foreach ($arrProjectOptions as $key => $optvalue) {
						$ddlImportprjSources .=	'<option value="'.$key.'"">'.$optvalue.'</option>';
						}
			$ddlImportprjSources .= '</select>';


	$htmlContent = <<<END_HTML_CONTENT
	<table style="margin-bottom:10px;" width="100%" cellspacing="0" cellpadding="5">
				<tbody><tr>
					<th class="textAlignLeft">Select project:</th>
					<td align="center">$ddlImportprjSources</td></tr>
					</tbody>
	</table>
	<div id="impbuilddata"></div>



END_HTML_CONTENT;

return $htmlContent;
	
}


function buildingandunitbasedonProject($database,$changeprjid)
{

	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT b.`id` as build_id, b.`project_id`, b.`building_name`, b.`location`, r.`id`as room_id, r.`project_id`, r.`building_id`, r.`room_name`, r.`description` FROM punch_building_data as b LEFT join `punch_room_data` as r on r.building_id = b.id WHERE b.`project_id` ='$changeprjid' ORDER BY ISNULL(r.id), b.building_name ASC  ";
       $db->execute($query);
       $buildingData=array();
      
	while ($row =$db->fetch())
	{
		 $roomData=array();
		$build_id=$row['build_id'];
		$room_id=$row['room_id'];
		 /*to fetch building data */
       $buildingData[$build_id]['build_id']=$row['build_id'];
       $buildingData[$build_id]['buildname']=$row['building_name'];
       $buildingData[$build_id]['location']=$row['location'];

       /*to fetch room data */
       $roomData['room_id'] =$row['room_id'];
       $roomData['project_id'] =$row['project_id'];
       $roomData['building_id'] =$row['building_id'];
       $roomData['room_name'] =$row['room_name'];
       $roomData['description'] =$row['description'];
       if($room_id !="")
       {
       $buildingData[$build_id]['unit'][$room_id]=$roomData;
   	}
    }
    $db->free_result();
// echo "<pre>";
// print_r($buildingData);
		$htmlContent = <<<END_HTML_CONTENT

<table id="tblImportCostCodes" style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="3px" border="0">
END_HTML_CONTENT;
	if($buildingData){
	foreach ($buildingData as $key => $bvalue) {
		$buildname=$bvalue['buildname'];
		$build_id=$bvalue['build_id'];
		$unit= $bvalue['unit'];
		

		$htmlContent .= <<<END_HTML_CONTENT
	<tr><th class="textAlignCenter borderBottom" style="padding-top:5px" width="2px;"><input id="buildImp_$build_id" class="build_check input-import-checkbox" value="$build_id" type="checkbox" onclick="selectAllbuild($build_id)"></th>
	<th  colspan="2" class="borderBottom" style="padding:3px 0 0 5px" align="left">$buildname</th></tr>
	
END_HTML_CONTENT;
if($unit)
{ 
	$htmlContent .= <<<END_HTML_CONTENT
	<tr><td colspan="2" style="padding: 10px 3px;" align="left" class="allsle"><input id="build_$build_id" class="input-import-checkbox" value="$build_id" type="checkbox" onclick="selectAllunits($build_id)">&nbsp;&nbsp;Select All</td></tr>
END_HTML_CONTENT;

	foreach ($unit as $ukt => $uvalue) {
		$room_id=$uvalue['room_id'];
		$room_name= $uvalue['room_name'];

		$htmlContent .= <<<END_HTML_CONTENT
	<tr>	
	<td colspan="2" align="left" ><input id="unitImp_$room_id" class="unit_$build_id" class="input-import-checkbox" value="$room_id" type="checkbox"><span style="padding-left:10px;" for="chkImput_$room_id">$room_name</span></td>
	</tr>
END_HTML_CONTENT;
}
}
	}
}else
{
	$htmlContent .= <<<END_HTML_CONTENT
	<tr>	
	<td></td><td colspan="2" align="left" style="padding-left:25px;">No Data Available</td>
	</tr>
END_HTML_CONTENT;

}

		$htmlContent .= <<<END_HTML_CONTENT
	</table>
END_HTML_CONTENT;
return $htmlContent;
	
}

//To insert building data
function InsertBuildingdata($building_name,$location,$description,$project_id){

	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT id from punch_building_data where  building_name='$building_name' and project_id = $project_id ";
	$db->execute($query1);
	$row1 = $db->fetch();
	$db->free_result();
	if($row1)
	{
		return array("id" => "0" , "res" => "");
	}else
	{
		
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "INSERT INTO punch_building_data(building_name,location,description,project_id) VALUES('$building_name','$location','$description','$project_id')";

        if($db->execute($query)){
            $building_id = $db->insertId; 
        }
        $db->free_result();
        $retdata ="<option value='$building_id'>$building_name</option>";
        return array("id" => "$building_id" , "res" => $retdata);
    }
}

//To Update building data
function UpdateBuildingdata($building_name,$location,$description,$project_id,$build_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "UPDATE `punch_building_data` SET `building_name`='$building_name' ,`location`= '$location',`description`= '$description' WHERE id = $build_id";
	$db->execute($query);
    $db->free_result();
    return '1';
}

//To Update Room data
function updateRoomDatas($room_id,$room_name,$description,$building_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "UPDATE `punch_room_data` SET `building_id`='$building_id' ,`room_name`= '$room_name',`description`= '$description' WHERE id = $room_id";
	$db->execute($query);
    $db->free_result();
    return '1';
}

//To Update unit name
function updateunitname($unit_id,$unit_name)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "UPDATE `punch_room_data` SET `room_name`= ? WHERE id = ?";
	$array1 = array($unit_name,$unit_id);
	$db->execute($query,$array1);
    $db->free_result();
    return '1';
}


//To insert Room data
function InsertRoomsdata($building_id,$room_name,$project_id){

	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT id from punch_room_data where  building_id=? and project_id = ? and room_name =? ";
	$array1 = array($building_id,$project_id,$room_name);
	$db->execute($query1,$array1);
	$row1 = $db->fetch();
	$db->free_result();
	if($row1)
	{
		return "0";
	}else
	{
	$db = DBI::getInstance($database);  // Db Initialize
	 $query = "INSERT INTO punch_room_data(`project_id`, `building_id`, `room_name`) VALUES(?,?,?)";
	 $array = array($project_id,$building_id,$room_name);

        if($db->execute($query,$array)){
            $room_id = $db->insertId; 
        }
        $db->free_result();
        return $room_id;
    }
}

//To insert defects data
function InsertpunchDefects($defect,$user_company_id){
	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT id from punch_defects where  user_company_id=? and defect_name =?";
	$array1 = array($user_company_id,$defect);
	$db->execute($query1,$array1);
	$row1 = $db->fetch();
	if($row1)
	{
		$db->free_result();
		return "0";
	}else
	{
		$db->free_result();
	 	$query = "INSERT INTO punch_defects(`user_company_id`, `defect_name`) VALUES(?,?)";
	 	$array = array($user_company_id,$defect);

        if($db->execute($query,$array)){
            $defect_id = $db->insertId; 
        }
        $db->free_result();
        return $defect_id;
    }
}

//To update defects
function UpdatepunchDefects($defect,$def_id,$user_company_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "UPDATE punch_defects SET `defect_name`=? where id=?";
	$queryArray = array($defect,$def_id);
    $db->execute($query,$queryArray);
    $db->free_result();


}

//To delete defects
function deletepunchDefects($database,$def_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "DELETE From punch_defects where id='$def_id'";
    if($db->execute($query))
    {
    	$data ="1";
    }else
    {
    	$data ="0";
    }
    $db->free_result();
    return $data;
}

//To delete Units
function deleteunit($database,$unit_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "DELETE From punch_room_data where id='$unit_id'";
    if($db->execute($query))
    {
    	$data ="1";
    }else
    {
    	$data ="0";
    }
    $db->free_result();
    return $data;
}

//To delete Building
function deletebuilding($database,$bul_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	//To delete the unit associated with the building
	$query = "DELETE From punch_room_data where building_id='$bul_id'";
    $db->execute($query);
    $db->free_result();
    //To delete the building
	$bulquery = "DELETE From punch_building_data where id='$bul_id'";
    if($db->execute($bulquery))
    {
    	$data ="1";
    }else
    {
    	$data ="0";
    }
    $db->free_result();
    return $data;
}


//To get all the building data
function loadBuildingsdata($project_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from punch_building_data where project_id ='$project_id' order by id ASC";
	$db->execute($query);
	$buildArr=array();
	while ($row =$db->fetch())
	{
		$id=$row['id'];
		$building=$row['building_name'];
		$buildArr[$id]= $building;
	}
       
        $db->free_result();
      
        return $buildArr;
}

//To check whether the building already exists or not in same project
function checkbuildexistornot($database,$key,$project_id)
{

	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from punch_building_data where  id=$key";
	$db->execute($query);
	$row = $db->fetch();

	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT id from punch_building_data where  building_name='".$row['building_name']."' and project_id = $project_id and location ='".$row['location']."' limit 1";
	$db->execute($query1);
	$row1 = $db->fetch();
	if($row1)
	{
	$buildId=$row1['id'];
	}else
	{
		$buildId='0';
	}

	$db->free_result();
	return $buildId;

}

//To check whether the unit already exists or not in same project
function checkunitexistornot($database,$unitid,$project_id,$building_id)
{

	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from punch_room_data where  id=$unitid";
	$db->execute($query);
	$row = $db->fetch();

	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT id from punch_room_data where  building_id='$building_id' and project_id = $project_id and room_name ='".$row['room_name']."' and description ='".$row['description']."' limit 1";
	$db->execute($query1);
	$row1 = $db->fetch();
	if($row1)
	{
	$unitId=$row1['id'];
	}else
	{
		$unitId='0';
	}

	$db->free_result();
	return $unitId;

}

//To check whether the unit mapped with punch item or not

function checkfieldexistInpunchListornot($field,$value)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT * from punch_item where  $field='$value'";
	$db->execute($query1);
	$row1 = $db->fetch();
	if($row1)
	{
		$exist="1";
	}else
	{
		$exist='0';
	}

	$db->free_result();
	return $exist;
}

