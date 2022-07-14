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
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('app/models/permission_mdl.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/Date.php');

$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

/**
* Display the Transmittal Grid
* @param project id
* @return html
*/
function renderSubcontractChangeOrderListViewRegistry($projectId,$user_company_id,$currentlyActiveContactId,$viewState,$is_pdf=null,$filteropt='all', $database,$checkpotential)
{	
	$session = Zend_Registry::get('session');
	$debugMode = $session->getDebugMode();
	$userRole = $session->getUserRole();
	
	$userCanManageSCO = checkPermissionForAllModuleAndRole($database,'subcontract_change_order');
	$userCanViewSCO = checkPermissionForAllModuleAndRole($database,'subcontract_change_order_view');
	if($userRole =="global_admin" )
	{
		$userCanManageSCO =$userCanViewSCO=1;
	}
	
	$SubChangeTableTbody = '';
	$incre_id=1;
	$db = DBI::getInstance($database);
	if($filteropt == 'all')
	{
		$filterby="";
	}else
	{
		$filterby=" and sd.status IN ('$filteropt')";
	}

	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	if($viewState == "costcode")
	{
	//  $query = "SELECT concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code,' ',cs.cost_code_description) as cost_code_abb, concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code) as cost_code, sd.*,cc.company,ccd.`division_number` FROM `subcontract_change_order_data` as sd 
	// inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id
	// inner join `cost_codes` as cs on cs.id = sd.costcode_id
	// inner join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id
	//  where `project_id` = $projectId  $filterby ORDER BY  cost_code_abb ASC  , sd.status Asc ,cc.company ASC,CAST(SUBSTR(cs.cost_code , 0, LENGTH(cs.cost_code)) AS UNSIGNED) ASC ";

	 $query = "SELECT sd.*, concat(ccd.`division_number`,'-',cs.cost_code) as cost_code, cc.company,ccd.`division_number`,ccd.division FROM `submittal_registry` as sd
left join `contacts` as c on c.`id` = sd.su_initiator_contact_id
left join `contact_companies` as cc on cc.`id` = c.contact_company_id
left join `cost_codes` as cs on cs.id = sd.su_cost_code_id
left join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id 
where `project_id` = $projectId  $filterby ORDER BY  cost_code ASC ,cc.company ASC,CAST(SUBSTR(cs.cost_code , 0, LENGTH(cs.cost_code)) AS UNSIGNED) ASC, sd.id DESC ";

	$db->execute($query);
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$cost_show=$vendor_show ="";
	$status_head='';
	$sub_status_head ="";
	$ic='1';
	foreach($records as $row)
	{
		$id      = $row['id'];
		$title 	= $row['su_title'];
		$sequence_number 	= $row['su_sequence_number'];
		$costcode_id   	= $row['su_cost_code_id'];
		$SCO_num= $row['cost_code'];
		$costcode_data   	= $row['cost_code'];
		$division_number= $row['division_number'];
		$subcontract_vendor_id   	= $row['su_creator_contact_id'];
		$description 	= $row['su_statement'];
		$vendor=$row['company'];
		$division=$row['division'];
		$su_spec_no=$row['su_spec_no'];
		
			$dataStatus="approved";
			$search_state= "'approved'";
			$SCO_num=$row['cost_code'];
   		

		$border='1';
   		//To get the attachment
   		$subAttach=AttachmentSuborderRegistry($id, $database);
   		$subAttachCount = $subAttach['count'];
		$subAttachFiles = $subAttach['files'];

		if($cost_show != $division_number)
		{
			$cost_show=$division_number;
			$head_insert=$cost_show;
			$code_insert_header='border-top:1px solid #888888;cursor: pointer;';
			$ic=1;
			$tinc='1';
			$subc=0;				
		}
		else
		{
			$head_insert='';
			$code_insert_header='cursor: pointer;';
			$subcontractTotal="";
			$ic++;

		}
		
		$arrReturn=checkstatusPositionRegistry($costcode_id,$projectId,$search_state, $database);
		$statePos =$arrReturn['count'];

		$subarr=subcontractTotalAndCountAgainstCostcodeRegistry($database,$costcode_id,$projectId,$search_state,$subcontract_vendor_id);
		$subPos =$subarr['count'];
	
		//Estimated amount
		$subEstimatedtot=calculateEstimatedAmountSubtotalRegistry($costcode_id,$projectId, $database,$checkpotential);
		$subEstimatedtot = Format::formatCurrency($subEstimatedtot);


		$shwsub=DisplayviewTotalRegistry($costcode_id,$projectId, $database,$checkpotential);
		
		if($debugMode){
			$scoIdBody = <<<END_OF_SCO_ID_BODY
			<td class="textAlignCenter">$id</td>
END_OF_SCO_ID_BODY;
		}
		$scoSpan = $debugMode ? '12' : '11';
		if($head_insert)
		{
			$SubChangeTableTbody .= <<<END_DELAYS_TABLE_TBODY
			<tr><td colspan=$scoSpan><b class="headsle">Division $division_number - $division</b></td></tr>
END_DELAYS_TABLE_TBODY;
			

		}
		//for delete
		if($status =='potential' && $userCanManageSCO)
		{
			$deloption ='<td class="textAlignCenter" id="manage-potential_data-record--" onclick="submittalRegistryDelete(&apos;'.$id.'&apos;)" > <span class="entypo-cancel-squared"></span></td>';
			$edit_stst="1";
		}else
		{
			$deloption ='<td class="textAlignCenter" id="manage-potential_data-record--"  > <span ></span></td>';
			$edit_stst="0";
		}
		
		if($userCanManageSCO  || $userRole == "global_admin"){
			$editClickSCO = "onclick='Submittalsregistry__loadCreateSuDialog(&apos;&apos;,&apos;&apos;,&apos;$id&apos;)'";
			$cursorClass = "";
		}else{
			$editClickSCO = "";
			$cursorClass = "table-default-cursor";
		}

		if ($is_pdf == '1') {
			$stylePdf = "style='display:none;'";
		}

		$db = DBI::getInstance($database);
		$query = "SELECT * FROM `submittals` WHERE su_cost_code_id=$costcode_id AND project_id=$projectId AND su_spec_no='".$su_spec_no."' ";
		$db->execute($query);
		$records = array();
		$row = $db->fetch();
		$tick='';

		if($row['id']){
			$tick='<span class="entypo-check" style="color:green"></span>';
		}

		//for delete
		// if($status =='potential' && $userCanManageSCO)
		// {

			$deloption ='<td class="textAlignCenter"  >
			<span class="entypo-pencil" id="manage-potential_data-record--" onclick="Submittalsregistry__loadCreateSuDialog(&apos;&apos;,&apos;&apos;,'.$id.')"></span> 
			 <span class="entypo-cancel-squared" id="manage-potential_data-record--" onclick="submittalRegistryDelete(&apos;'.$id.'&apos;)"></span> 
			 <a href="/modules-submittals-form.php?type=draft_'.$id.'"><span class="entypo-export"></span></a>
			 '.$tick.'
			 </td>';
			$edit_stst="1";
		// }else
		// {
		// 	$deloption ='<td class="textAlignCenter" id="manage-potential_data-record--"  > <span ></span></td>';
		// 	$edit_stst="0";
		// }

		if ($subAttachCount > 0) {
			$linkDocument = "
			<span id='documentLinkShow_$id' class='hoverLink subConchangeOrderbtn_$id' style='color:#06c;text-decoration:underline;'>Link</span>
			<div id='fileLinkShow_$id' class='holdSubConChangeOrder dropdown-content-change-order' $stylePdf>$subAttachFiles</div>
			";
			$tdOnclick = 'onclick="showFileDropdownSub('.$id.')"';
		}else{
			$linkDocument = "";
			$tdOnclick = $editClickSCO;
		}


		   $SubChangeTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-potential_data-record--" class="row_$id list-row table-row-tooltip" style="$code_insert_header">
		$scoIdBody	
			<td class="textAlignRight" id="manage-potential_data-record--" $editClickSCO>$incre_id</td>
			<td class="textAlignRight" id="manage-potential_data-record--" $editClickSCO>$SCO_num</td>
			<td class="textAlignRight" id="manage-potential_data-record--" $editClickSCO>$su_spec_no</td>
			<td class="textAlignLeft" id="manage-potential_data-record--" $editClickSCO>$title</td>
			<td class="textAlignLeft " id="manage-potential_data-record--" $editClickSCO><div width="100%" class="break_content" style="height:100%;" data-toggle="tooltip" title="" data-original-title="$description">$description</div></td>
			$deloption

			</tr>

END_DELAYS_TABLE_TBODY;
//<td class="textAlignLeft" id="manage-potential_data-record--" ><input type="button" id="create_COR_$id" value="Create COR" style="padding:1px 3px;!important" onclick="emailSubChangeOrder($id,$user_company_id,$projectId,$currentlyActiveContactId)"><input type="button" id="create_OCO_$id" value="Create OCO" style="padding:1px 3px;!important" onclick="OwnerChangeOrder($id,$user_company_id,$projectId,$currentlyActiveContactId)"> </td>
			$scoSpan2 = $debugMode ? '4' : '3';
		$incre_id++;

}
	if($SubChangeTableTbody==""){
		$SubChangeTableTbody='<tr><td colspan="11">No data Exist</td></tr>';
		$border='0';
	}else
	{
		
	}
	if($debugMode){
		$scoIdHead = <<<END_OF_SCO_ID_HEAD
		<th class="textAlignCenter ">SCO ID</th>
END_OF_SCO_ID_HEAD;
	}
	$htmlContent = <<<END_HTML_CONTENT
<table id="SubcontracttblTabularData" class="potential-grid table-suborder-view sub_selectST $cursorClass" border="$border" cellpadding="5" style="border-collapse:collapse;" width="100%">
	<thead>
		<tr class="permissionTableMainHeader">
		$scoIdHead
		<th class="textAlignRight" style="width: 40px;">S.No</th>
		<th class="textAlignRight" style="width: 80px;">Cost code</th>
		<th class="textAlignRight" style="width: 80px;">Specification No</th>
		<th class="textAlignLeft">Title</th>
		<th class="textAlignLeft">Notes</th>
		<th class="textAlignLeft" style="width: 35px;">Action</th>
		</tr>
	</thead>
	<tbody class="">
		$SubChangeTableTbody
	</tbody>
</table>

END_HTML_CONTENT;
}
//Subcontractor View
if($viewState == "subcontractor")
	{
//SELECT sd.* FROM `subcontract_change_order_data` as sd 
	// where `project_id` = $projectId ORDER BY `costcode_data` ASC
	$query = "
	SELECT concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code,' ',cs.cost_code_description) as cost_code_abb, sd.*,cc.company FROM `subcontract_change_order_data` as sd
	inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id 
	inner join `cost_codes` as cs on cs.id = sd.costcode_id
	inner join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id
	where `project_id` = $projectId $filterby ORDER BY cc.company ASC,cost_code_abb ASC , sd.status Asc, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC ";
	$db->execute($query);
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$cost_show="";
	$sub_head="";
	$sub_insert='0';
	$status_heads="";
	$status_head="";
	$status_inserts='0';
	$ic='1';
	foreach($records as $row)
	{
		$id      = $row['id'];
		$title 	= $row['title'];
		$costcode_id   	= $row['costcode_id'];
		$SCO_num=$sequence_number	= $row['sequence_number'];
		$costcode_data   	= $row['cost_code_abb'];
		$estimated_amount= $row['estimated_amount'];
		$subcontract_vendor_id   	= $row['subcontract_vendor_id'];
		$created_at  	= $row['created_at'];
		$due_date  	= $row['due_date'];
		$status_notes  	= $row['status_notes'];
		$description 	= $row['description'];
		$vendor 	= $row['company'];
		$status	= $row['status'];
		if($status=="potential")
		{
			$dataStatus="potential";
			$search_state= "'potential'";
			$SCO_num=str_pad($SCO_num, 3,'0', STR_PAD_LEFT); 
		}else if($status=="rejected")
		{
			$dataStatus="rejected";
			$search_state= "'rejected'";
			$SCO_num=str_pad($SCO_num, 3,'0', STR_PAD_LEFT); 
		}
		else
		{
			$dataStatus="approved";
			$search_state= "'approved'";
			$SCO_num=$row['approve_prefix'];

		}


		$dateObj = DateTime::createFromFormat('Y-m-d', $created_at);
   		$s_date = $dateObj->format('m/d/Y');
   		if($due_date !='0000-00-00')
		{
   		$dateObj1 = DateTime::createFromFormat('Y-m-d', $due_date);
   		$e_date = $dateObj1->format('m/d/Y');
   		}else
   		{
   			$e_date = '';
   		}
   		//Status
   		


		$inline_status=ucfirst($status);
		$border='1';


   		//To get the attachment
   		$subAttach=AttachmentSuborderRegistry($id, $database);
   		$subAttachCount = $subAttach['count'];
		$subAttachFiles = $subAttach['files'];
   		$onestate='0';

		if($cost_show != $costcode_data)
		{
		 	$cost_show=$costcode_data;
			$code_data=explode(' ', $costcode_data);
			$head_insert=$code_data[0];
			$code_insert_header='border-top:1px solid #888888;cursor: pointer;';
			$ic=1;
			$stinc='1';
			$chead =1; //For getting the costcode data change

			//status total
			if($status_head != $dataStatus)
			{
				$status_head=$dataStatus;
		 		$onestate = '1';
			}else{
				$onestate = '1';
			}
		}
		else
		{
			$head_insert='';
			$code_insert_header='cursor: pointer;';
			$subcontractTotal="";
			$ic++;
			//status total
				if($status_head != $dataStatus)
				{
					$status_head=$dataStatus;
			  		$onestate=$stinc='1';  // to restrict the imcrement for subcontractor
				}
			$chead++;
		}

		//Subcontractor heading
		if($sub_head != $vendor)
		{
		 	$sub_head=$vendor;
			$sub_insert='1';
			$stinc='1';
			$shead =1;//to calculte the subcontractor row
			//status total
			if($status_head != $dataStatus)
			{
				$status_head=$dataStatus;
			}
		}else
		{
			$sub_insert='0';
			//status total
				if($status_head != $dataStatus)
				{
					$status_head=$dataStatus;
			  		$stinc='1';
				 	
				}else
				{
					if(!$onestate)
					{
					$stinc++;
					}
					
				}
				$shead++;
		}

		
		$arrReturn=subcontractorcheckstatusPositionRegistry($costcode_id,$projectId,$search_state,$subcontract_vendor_id, $database);
		$statePos =$arrReturn['count'];
		$tot_estimate  =$arrReturn['estimated_amount'];
		
		//Estimated amount
		$subEstimatedtot = calculateSubtotalForSubcontractViewRegistry($subcontract_vendor_id,$projectId, $database,$checkpotential);
		 $subEstimatedtot = Format::formatCurrency($subEstimatedtot);
 		$estimated_amount = Format::formatCurrency($estimated_amount);


		$shwsub =  DisplaySubtotalInSubViewRegistry($subcontract_vendor_id,$projectId, $database,$checkpotential);

		// $shwsub=checkseq($costcode_id,$projectId);
		$subcontractTotal="<tr class='purStyle'><td colspan=7 class='textAlignRight '><b>Subcontractor Total</b></td><td align='right' class='' style='padding-right:5px;'><b>$subEstimatedtot</b></td><td colspan=$scoSpan2 class='textAlignRight'></td></tr>";
		if($debugMode){
			$scoIdBody = <<<END_OF_SCO_ID_BODY
			<td class="textAlignCenter">$id</td>
END_OF_SCO_ID_BODY;
		}
		$scoSpan = $debugMode ? '12' : '11';
		if($head_insert || $sub_insert =='1')
		{
			$SubChangeTableTbody .= <<<END_DELAYS_TABLE_TBODY
			   		<tr class="headsle costStyle"><td colspan=$scoSpan><b>$vendor</b></td></tr>

END_DELAYS_TABLE_TBODY;

		}
		if($chead =='1')
		{
			$SubChangeTableTbody .= <<<END_DELAYS_TABLE_TBODY
			   		<tr class="headsle "><td colspan=$scoSpan><b>$costcode_data</b></td></tr>

END_DELAYS_TABLE_TBODY;

		}

		//for delete
		if($status =='potential' && $userCanManageSCO)
		{
			$deloption ='<td class="textAlignCenter" id="manage-potential_data-record--" onclick="submittalRegistryDelete(&apos;'.$id.'&apos;)" > <span class="entypo-cancel-squared"></span></td>';
			$edit_stst="1";
		}else
		{
			$deloption ='<td class="textAlignCenter" id="manage-potential_data-record--"  > <span ></span></td>';
			$edit_stst="0";
		}
		$db = DBI::getInstance($database);
		$costCodeQuery = "
		SELECT ccd.`division_number`,cc.`cost_code`,cc.`cost_code_description` FROM `subcontract_change_order_data` sco
		LEFT JOIN `cost_codes` cc ON cc.`id`= sco.`costcode_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`=cc.`cost_code_division_id` WHERE  sco.id= $id";
		$db->execute($costCodeQuery);
		$costCodeRow = $db->fetch();
		$db->free_result();
		$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
		$costCodeDetail = $costCodeRow['division_number'].$costCodeDividerType.$costCodeRow['cost_code'].'&nbsp;'.$costCodeRow['cost_code_description'];
   	
		if($userCanManageSCO  || $userRole == "global_admin"){
			$editClickSCO = "onclick='subChangeOrderEdit(&apos;$id&apos;,&apos;$edit_stst&apos;)'";
			$cursorClass = "";
		}else{
			$editClickSCO = "";
			$cursorClass = "table-default-cursor";
		}

$SubChangeTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-potential_data-record--" class="row_$id list-row table-row-tooltip" style="$code_insert_header"  >
		$scoIdBody
                <td class="textAlignCenter" id="manage-potential_data-record--" $editClickSCO>$SCO_num</td>
			<td class="textAlignCenter" id="manage-potential_data-record--" $editClickSCO>$title</td>
			<td class="textAlignLeft" id="manage-potential_data-record--" $editClickSCO>$costcode_data</td>
			<td class="textAlignLeft" id="manage-potential_data-record--" $editClickSCO>$s_date</td>
			<td class="textAlignLeft" id="manage-potential_data-record--" > $inline_status</td>
			<td class="textAlignLeft " id="manage-potential_data-record--" $editClickSCO><div width="100%" class="break_content" style="height:100%;" data-toggle="tooltip" title="" data-original-title="$description">$description</div></td>			
			$deloption

			</tr>

END_DELAYS_TABLE_TBODY;
$scoSpan2 = $debugMode ? '4' : '3';
		if($filteropt=='all')
		{
			if( $shead == $shwsub)
			{
				$SubChangeTableTbody .=$subcontractTotal;
			}
		}


		
		$incre_id++;
}
	if($SubChangeTableTbody==""){
		$SubChangeTableTbody='<tr><td colspan=$scoSpan>No data Exist</td></tr>';
	}
	if($debugMode){
		$scoIdHead = <<<END_OF_SCO_ID_HEAD
		<th class="textAlignCenter ">SCO ID</th>
END_OF_SCO_ID_HEAD;
	}
	$htmlContent = <<<END_HTML_CONTENT
<table id="SubcontracttblTabularData" class="potential-grid table-suborder-view sub_selectST $cursorClass" border="$border" cellpadding="5" width="100%">
	<thead>
		<tr class="permissionTableMainHeader">
		$scoIdHead
		<th class="textAlignCenter ">SCO</th>
		<th class="textAlignCenter ">Title</th>
		<th class="textAlignCenter ">Cost-code</th>
		<th class="textAlignCenter ">Date</th>
		<th class="textAlignLeft ">Status</th>
		<th class="textAlignLeft ">Description</th>
		<th class="textAlignCenter ">Action</th>
		</tr>
	</thead>
	<tbody class="">
		$SubChangeTableTbody
	</tbody>
</table>

END_HTML_CONTENT;

		}

//End of Subcontractor View	

	return $htmlContent;
}

function EditSubOrderDialogRegistry($database, $user_company_id, $project_id, $currently_active_contact_id, $suborderId)
{
	
	$db = DBI::getInstance($database);
 	$query = "SELECT * FROM subcontract_change_order_data WHERE id='$suborderId'";
	$db->query($query);
	
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}

	$subId 					= $records[0]['id'];
	$title 					= $records[0]['title'];
	$sequence_number  		= $records[0]['sequence_number'];
	$costcode_id 			= $records[0]['costcode_id'];
	$costcode_data 	 		= $records[0]['costcode_data'];
	$expo_id   				= $records[0]['expo_id'];
	$rfi_id   				= $records[0]['rfi_id'];
	$estimated_amount  		= $records[0]['estimated_amount'];
	$status   				= $records[0]['status'];
	$description  	 		= $records[0]['description'];
	$status_notes   		= $records[0]['status_notes'];
	$created_at    			= $records[0]['created_at'];
	$due_date   			= $records[0]['due_date'];
	$subcontract_vendor_id 	= $records[0]['subcontract_vendor_id'];
	$subcontractor_id       = $records[0]['subcontractor_id'];
	$approve_prefix  		= $records[0]['approve_prefix'];
	$sco_file_manager_file_id=$records[0]['sco_file_manager_file_id'];
	$SCO_num				= $records[0]['sequence_number'];
	if($approve_prefix=="")
	{
		$new_next=str_pad($sequence_number, 3,'0', STR_PAD_LEFT); 
		$exetitle='SCO-'.$new_next;
	}else
	{
		$exetitle=$approve_prefix;
	}
	if($status=="potential")
		{
			$SCO_num=str_pad($SCO_num, 3,'0', STR_PAD_LEFT); 
		}else if($status=="rejected")
		{
			$SCO_num=str_pad($SCO_num, 3,'0', STR_PAD_LEFT); 
		}
		else
		{
			$SCO_num=$exetitle;
		}	
	$dateObj = DateTime::createFromFormat('Y-m-d', $created_at);
	$created_date = $dateObj->format('m/d/Y');
	if($due_date !='0000-00-00')
	{
	$dateObj1 = DateTime::createFromFormat('Y-m-d', $due_date);
	$due_end_date = $dateObj1->format('m/d/Y');
	}else
	{
		$due_end_date = '';
	}
	

	//Attachments

	$attachmentQuery = "SELECT s.attachment_file_manager_file_id, f.virtual_file_name,s.is_executed,s.sort_order FROM file_manager_files as
 f JOIN subcontract_change_order_attachments s  ON f.id = s.attachment_file_manager_file_id  WHERE s.suborder_id='$suborderId'  ORDER BY s.sort_order";
	
		$db->query($attachmentQuery);
		$attachmentRecords = array();
		while($attachmentRow = $db->fetch())
		{
			$attachmentRecords[] = $attachmentRow;
		}
		
		$attachmentIds = array();
		$attachmentHtml = '';
		$executeattachmentHtml = '';
		$attachIds="";
		$executiveCount =1;
		foreach($attachmentRecords as $attachmentRecord){
			$attachmentId = $attachmentRecord['attachment_file_manager_file_id'];
			$attachmentName = $attachmentRecord['virtual_file_name'];
			$is_executed = $attachmentRecord['is_executed'];
			$attachIds .= $attachmentId.',';

			require_once('lib/common/FileManagerFile.php');
			$value = $attachmentId;
			$FileManagerFile = FileManagerFile::findById($database, $attachmentId);
			$attachmenturl = $FileManagerFile->generateUrl();
			$attachmentIds[] = $attachmentId;
			if($is_executed=='Y')
			{
				$executeattachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="uploadedfile"><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"><a href="javascript:deleteFileManagerFile(\'record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'\', \'manage-file_manager_file-record\', \''.$attachmentId.'\');deletesubcontractattachment(&apos;'.$attachmentId.'&apos;,&apos;'.$suborderId.'&apos;);" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;<a target="_blank" href="'.$attachmenturl.'">'.$attachmentName.'</a><input class="exefileid" value="'.$value.'" type="hidden"></li>
			';
			$executiveCount++;
			}else
			{
			$attachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="uploadedfile"><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"><a href="javascript:deleteFileManagerFile(\'record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'\', \'manage-file_manager_file-record\', \''.$attachmentId.'\');deletesubcontractattachment(&apos;'.$attachmentId.'&apos;,&apos;'.$suborderId.'&apos;);" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;<a target="_blank" href="'.$attachmenturl.'">'.$attachmentName.'</a><input class="upfileid" value="'.$value.'" type="hidden"></li>
			';
			}
		}

	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}


	if ($attachmentHtml =="")  {
		$attachmentHtml = '<li class="placeholder">No Files Attached</li>';
	}
	if ($executeattachmentHtml =="") {
		$executeattachmentHtml = '<li class="placeholder">No Files Attached</li>';
	}
	

	// FileManagerFolder
	$virtual_file_path = '/Subcontract Change Order/'.$costcode_data.'/Attachments/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $rfiFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Subcontract Change Order/'.$costcode_data.'/Attachments/';
	//$input->virtual_file_name = 'Attachment #1';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf';
	$input->post_upload_js_callback = "SubcontractChangeOrderDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record','N')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	//starts
	$rfiCostCodesElementId = "subcontract_costcode";
	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$js = 'style="width:95%"';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $costcode_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $rfiCostCodesElementId;
	$costCodesInput->firstOption = '<option value="">Select A Cost Code </option>';
	$costCodesInput->selectCssStyle = 'style="width: 220px;" class="moduleRFI_dropdown4"';
	$costCodesInput->selectedOption = $costcode_id;
	$rfiDraftsHiddenCostCodeElementId = "subcontract_costcode";
	$costCodesInput->additionalOnchange = "updateSubcontract(this.value, '$user_company_id' ,'$project_id');";
	$ddlCostCodes = buildCostCodeDropDownListhavesubcontracts($costCodesInput);
	$userTypes = loadopenRFIRegistry($database,$project_id);
	$userTypes = array('' => 'Select') + $userTypes;

	$expoTypes = loadExposureRegistry($database);
	$expoTypes = array('' => 'Select') + $expoTypes;

	$delayUserTypes = "rfi_reference";
	$js = 'id="rfi_reference" class="target moduleRFI_dropdown4 "  ';
	$prependedOption = '<option value="">Select a RFI</option>';
	$ddlRFIListId = "rfi_reference";
	$ddlRFIList = PageComponents::dropDownList($ddlRFIListId, $userTypes, $rfi_id, null, $js, null);

	$delayUserTypes = "expo_reference";
	$js = 'id="expo_reference" class="target moduleRFI_dropdown4 "  ';
	$prependedOption = '<option value="">Select Exposure</option>';
	$ddlExpoListId = "expo_reference";
	$ddlExpoList = PageComponents::dropDownList($ddlExpoListId, $expoTypes, $expo_id, null, $js, null);

	$rfi_attachment_source_contact_id = $currently_active_contact_id;
	$rfi_creator_contact_id = $currently_active_contact_id;
	$curdate=date('m/d/Y');
	$selDis='';
	$opt_value ="<option value='potential' ";
	if($status =='potential')
	{
	$opt_value .="selected";
	}
	$opt_value .=">Potential</option>
	<option value='approved'";
	if($status =='approved')
	{
	$opt_value .="selected";
	}
	$opt_value .=">Approved</option><option value='rejected'";
	if($status =='rejected')
	{
	$opt_value .="selected";
	$selDis="disabled";
	}
	$opt_value .=">Rejected</option>";

	$resOutput=SubcontractFinalSignRegistry($database,$costcode_id,$user_company_id,$project_id,$subcontractor_id);


	 $estimated_amount=Format::formatCurrency($estimated_amount);

	 //For email Filter option
	$emailfilter = array('0'=>'All','1'=>'Roles','2'=>'Company');
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_emailfilter_id--$dummyId";
	$js = 'id="emailfilter" class="target moduleRFI_dropdown4 " onchange="emailfilters(this.id,this.value)"  ';
	$prependedOption = '<option value="">Select a Type</option>';
	$selectedOption = "";
	$emailfilterId = "emailfilter";
	$emailfilterList = PageComponents::dropDownList($emailfilterId, $emailfilter, '', null, $js, null,$selectedOption);
	//For roles 
	$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;
	$projectrole = projectroles($database);
	unset($projectrole[$AXIS_USER_ROLE_ID_BIDDER]);
	$projectrole = array('' => 'Select a Role') + $projectrole;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_role" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailroles(this.value)"';
	$prependedOption = '<option value="">Select a Role</option>';
	$projectroleListId = "project_role";
	$projectroleList = PageComponents::dropDownList($projectroleListId, $projectrole, '', null, $js, null);
	//For Company 
	$projectCompany = companyWithoutBidder($project_id, $database);
	$projectCompany = array('' => 'Select a Company') + $projectCompany;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_company" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailcompany(this.value)" ';
	$prependedOption = '<option value="">Select Company</option>';
	$projectCompanyId = "projectCompany";
	$projectCompanyList = PageComponents::dropDownList($projectCompanyId, $projectCompany, '', null, $js, null);
	
	

	// To:
	// rfi_recipient_contact_id
	/*load membre by roles*/
	// 10 sub contractor
	// 3 user
	// 5 project manager 
	// 4 project excutive
	// $rolesMemID = '10,5,4';
	// $rolesMemID = '10';
	$db = DBI::getInstance($database);
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($db, $project_id, 'subcontract_change_order');

	$rfiDraftsHiddenProjectTeamMembersToElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId";
	$selectedOption = "";
	$js = ' class="moduleRFI_dropdown4 required emailGroup to_contact" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenProjectTeamMembersToElementId.'\');"';
	$prependedOption = '<option value="">Select a contact</option>';
	$ddlProjectTeamMembersToId = "ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId";	
	$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId);

	// Cc:
	// rfi_additional_recipient_contact_id

	$ddlProjectTeamMembersCcId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="Subchange__addRecipient(this);" class="moduleRFI_dropdown4 emailGroup cc_contact"';
	$ddlProjectTeamMembersCc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersCcId);

	// Bcc:

	$ddlProjectTeamMembersBccId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersBccId);

	// Convert to temp file upload with temp GUID
	$costcode_arr = explode(" ", $costcode_data,2);
	$virtual_file_name=$costcode_arr[1].'-'.$exetitle."-Executed_$executiveCount.pdf";
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-executed_records';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Subcontract Change Order/'.$costcode_data.'/Attachments/';
	$input->virtual_file_name = $virtual_file_name;
	$input->prepend_date_to_filename = true;
	$input->drop_text_prefix="";
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf';
	$input->post_upload_js_callback = "SubcontractChangeOrderDraftAttachmentUploaded(arrFileManagerFiles, 'container--executed_records','Y')";
	$fileUploaderexe = buildFileUploader($input);
	$fileUploaderProgressWindowexe = buildFileUploaderProgressWindow();

	$title = str_replace('\'', '&apos;',$title);

	//To fetch the file manager file for transmittal
	// $attachIds =rtrim($attachIds,',');
	// $sco_file_url = fetchSCOFileId($suborderId,$project_id,$attachIds);
	$sco_file_url = fetchSCOFileURLRegistry($db,$sco_file_manager_file_id);
	if($sco_file_url =="")
	{
		$shoval="";
	}else
	{
		$shoval='<input type="button"  class="viewpdf" style="visibility:hidden;" onclick="SubChangeOrders__openCoPdfInNewTab(&apos;'.$sco_file_url.'&apos;);" value="View SCO PDF" style="font-size: 10pt;">';
	}

	// Start of cost break down
	$costdata = getSCOcostbreakdownDataRegistry($database,$suborderId);
	$costanalysbreak ="";
	$subtotal =0;

	if($costdata)
	{
			$k= 1;
			foreach ($costdata as $key => $costvalue) {
				$costdescription = $costvalue['description'];
				$Sub = $costvalue['Sub'];
				$cost = $costvalue['cost'];
				$subtotal = floatval($cost) + $subtotal;

				if($k=="1")
				{
					$addbutton ='<div class="tcol" style="vertical-align: bottom;padding-bottom: 12px;">
									<a href="javascript:void(0);" class="add_button entypo-plus-circled " title="Add field" onclick="addscobreakdown()"></a>        
								</div>';
				}else
				{
					$addbutton ='<div class="tcol" style="vertical-align: bottom;padding-bottom: 12px;">
									<a href="javascript:void(0);" class="remove_button entypo-minus-circled " title="Remove field"></a>        
								</div>';
				}
				
			$costanalysbreak .= <<<END_COST_BREAK
						
							<div class="trow cost_div divdrag">
								<div class="tcol" style="width: 0.5%;">		
									<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
								</div>
								<div class="tcol" style="width: 27%;">		
									<input class="required" type="text" name="descript[]" id="descript[]" value="$costdescription"/>
								</div>
								<div class="tcol">
								   <input class="" type="text" name="sub[]" id="sub[]" value="$Sub"/>
								</div>
								<div class="tcol">
								   <input class="Number required sub_input_value" type="text" name="cost[]" id="cost[]"  value="$cost" onkeyup="setTimeout(calcScoSubtotal(),2000)"/>
								</div>
								$addbutton
								
							</div>
END_COST_BREAK;
			 $k++;
			}
			$costanalysbreak .= "</div>";

	}else
	{
	$costanalysbreak ='
	
							<div class="trow cost_div divdrag">
							<div class="tcol" style="width: 0.5%;">		
									<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
								</div>
								<div class="tcol" style="width: 27%;">		
									<input class="required" type="text" name="descript[]" id="descript[]" value=""/>
								</div>
								<div class="tcol">
								   <input class="" type="text" name="sub[]" id="sub[]" value=""/>
								</div>
								<div class="tcol">
								   <input class="Number required sub_input_value" type="text" name="cost[]" id="cost[]"  value="" onkeyup="setTimeout(calcScoSubtotal(),2000)"/>
								</div>
								<div class="tcol" style="vertical-align: bottom;padding-bottom: 12px;">
									<a href="javascript:void(0);" class="add_button entypo-plus-circled " title="Add field" onclick="addscobreakdown()"></a>        
								</div>
							</div>
						</div>';
	}

	// End of cost break down


	// start of tax break down
	$retdata = getSCOtaxDataRegistry($database,$suborderId);
	$dyna_desp= "";
	
	if($retdata)
	{
		$i= 1;

		foreach ($retdata as $key => $taxvalue) {
			$content = $taxvalue['content'];
			$percentage = $taxvalue['percentage'];
			$cost = $taxvalue['cost'];

			if($i =="1")
			{
				$taxbutton ="<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
        		<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addscocostbreakdown()'></a>        
        	</div>";
			}else
			{
				$taxbutton ="<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
        		<a href='javascript:void(0);' class='remove_button entypo-minus-circled ' title='Remove field' ></a>        
        	</div>";
			}

			$dyna_desp .= <<<END_DYNA_DESP

 		<div class='trow cont_div contdrag '>  
 		<div class="tcol" style="width: 0.5%;">		
			<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"></div>
         	<div class='tcol' style='width: 7%;'>
        		<input type='text' class='' name='content[]' id='content[]' value="$content" /> 
          	</div>
          	<div class='tcol' style='width: 1%;'>%</div>
          	<div class='tcol' style='width: 7%;'>
         		<input type='text' class='Number sub_input_value' name='percentage[]' id='percentage[]' value='$percentage' onkeyup='calcScoSubtotal()'/> 
          	</div>
         	<div class='tcol' style='width: 1%; text-align: center;'><b>OR</b></div>
          	<div class='tcol' style='width: 1%;'>$</div>
          	<div class='tcol' style='width: 9%;'>
         		<input type='text' class='Number sub_input_value' name='contotal[]' id='contotal[]' value='$cost' onkeyup='setTimeout(calcScoSubtotal(),2000)'/>
         	</div>
         	$taxbutton
          	
         </div>
END_DYNA_DESP;
$i++;
		}
	}
	else{
	$dyna_desp ="
 		<div class='trow cont_div contdrag '>  
 		<div class='tcol' style='width: 0.5%;'>		
			<img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div>
         	<div class='tcol' style='width: 7%;'>
        		<input type='text' class='' name='content[]' id='content[]' value='' /> 
          	</div>
          	<div class='tcol' style='width: 1%;'>%</div>
          	<div class='tcol' style='width: 7%;'>
         		<input type='text' class='Number sub_input_value' name='percentage[]' id='percentage[]' value='' onkeyup='calcScoSubtotal()'/> 
          	</div>
         	<div class='tcol' style='width: 1%; text-align: center;'><b>OR</b></div>
          	<div class='tcol' style='width: 1%;'>$</div>
          	<div class='tcol' style='width: 9%;'>
         		<input type='text' class='Number sub_input_value' name='contotal[]' id='contotal[]' value='' onkeyup='setTimeout(calcScoSubtotal(),2000)'/>
         	</div>
          	<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
        		<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addscocostbreakdown()'></a>        
        	</div>
         </div>
    ";
	}
	// End of tax break down
$htmlContent = <<<END_HTML_CONTENT
<form name="formCreatesuborder" id="formCreatesuborder" >
	<div id="record_creation_form_container--create-subChange-record--">
	<div class="SUBCONTRACT_table_dark_header">$SCO_num — $title</div>
		<div class="RFI_table_create">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody>
				<input type="hidden" id="subChange_id" value="$suborderId" />
				<input type="hidden" id="source_id" value="" />
		
				<tr>
					<td width="70%" class="RFI_table_header2" colspan="3">Name</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif " colspan="3">
					<input type="text" class="RFI_table2 required target" id="title" value='$title'/>
					</td>
				</tr>
							
				<tr>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
				<td width="40%" class="RFI_table_header2 border_right_none" colspan="3">Cost Code</td>
				<td width="60%" class="RFI_table_header2" >Subcontractor</td>
				
				</tr>
				<tr>
				<td class="RFI_table2_content font_serif " colspan="3">
					<span class="moduleRFI">
					$ddlCostCodes</span>
					</td>
					<td class="RFI_table2_content font_serif required" >
					<span class="moduleRFI">
					<select id="vendorCostCode" class="moduleRFI_dropdown4" >
					$resOutput</select></span>
					</td>
					
					</tr>
				</table>
				</td>
				</tr>
				
				<tr>
				<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
				<td class="RFI_table_header2  border_right_none  " colspan="3" width="40%" >Status</td>
				<td class="RFI_table_header2   width="60%" >Exposure</td>
				</tr>
				<tr>
	
				<td class="RFI_table2_content" colspan="3">
				<span class="moduleRFI sub_selectST">
					<select id="su_status" class="moduleRFI_dropdown4" >
					$opt_value
					</select>
					</span>
					</td>
					<td class="RFI_table2_content" colspan="3">
						<span class="moduleRFI">$ddlExpoList</span>
					</td>
				</tr>
				</table>
				</td>
				</tr>
				<tr>
					<td class="RFI_table_header2 " colspan="3">Status Notes</td>
				</tr>
				<tr>
					<td class="RFI_table2_content" colspan="3">
						<p><textarea class="RFI_table2  target" id="status_notes"  style="height:45px;">$status_notes</textarea></p>
					</td>
					</tr>
				
				<tr>
					<td class="RFI_table_header2 " colspan="3">Description</td>
				</tr>
				<tr>
					<td class="RFI_table2_content" colspan="3">
						<p><textarea class="RFI_table2 required target" id="description"  style="height:45px;">$description</textarea></p>
					</td>
					</tr>

					<tr><td>
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr><td width="50%" class="RFI_table_header2">Created Date</td>
					<td width="50%" class="RFI_table_header2">Executed Date</td></tr>
					<tr>
					<td class="RFI_table2_content font_serif ">
					<input type="text" class="RFI_table2  datepicker" id="sub_create_date" value="$created_date"/>
					</td>
					<td class="RFI_table2_content font_serif ">
					<input type="text" class="RFI_table2  datepicker" id="sub_executed_date" value="$due_end_date"/>
					</td>
					</tr>
					</tbody></table>
					</td></tr>

					<tr><td>
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr><td width="50%" class="RFI_table_header2"> Executed (signed) SCO document</td>
					<td width="50%" class="RFI_table_header2">Attached Files </td></tr>

					<tr>
					<input type='hidden' name="executeval" id ="executeval" value="$executiveCount">
					<input type='hidden' name="executefolder" id ="executefolder" value="$rfiFileManagerFolder->file_manager_folder_id">
					<td class="RFI_table2_content" width="50%" id="executive_uploads">
					{$fileUploaderexe}{$fileUploaderProgressWindowexe}
					</td>
					<td id="tdAttachedFilesList" class="RFI_table2_content" colspan="3">
						<ul style="list-style:none; margin:0; padding:0" id="container--executed_records" class="subcontractor_attachments divslides">
							$executeattachmentHtml
						</ul>
					</td>
					</tr>
					</tbody>
					</table>
					</td></tr>


			</tbody>
		   </table>
		</div>
		<div class="RFI_table_create margin0px">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody>
				
				<tr>
					<td class="RFI_table_header2 " colspan="3">RFI Reference </td>
				</tr>
				<tr>
					<td class="RFI_table2_content" colspan="3">
						<span class="moduleRFI">$ddlRFIList</span>
					</td>
					</tr>
				<tr>
					<td width="70%" class="RFI_table_header2" colspan="3">Select A File To Attach:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content" colspan="3">{$fileUploader}{$fileUploaderProgressWindow}</td>
</td>
				</tr>
				<tr>
					<td class="RFI_table_header2" colspan="3">Attached Files:</td>
				</tr>
				<tr>
					<td id="tdAttachedFilesList" class="RFI_table2_content" colspan="3">
						<ul style="list-style:none; margin:0; padding:0" id="container--request_for_information_attachments--create-request_for_information-record" class="subcontractor_attachments divslides">
							$attachmentHtml
						</ul>
					</td>
				</tr>
				<tr>
					<td width="70%" class="RFI_table_header2" colspan="3">Filter To Select Email Id(s)</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif  border_right_none">
					$emailfilterList
					</td>
					<td class="RFI_table2_content font_serif  border_right_none" >
					$projectroleList
					</td>
					<td class="RFI_table2_content font_serif  border_right_none" >
					$projectCompanyList
					</td>
				</tr>
				<tr>
					<td style="vertical-align: middle;" class="RFI_table_header2" colspan="3">Email:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content Subsearch" colspan="3">
								
						<p>To: &nbsp;$ddlProjectTeamMembersTo</p>
						<div>
							<p>Cc: &nbsp;$ddlProjectTeamMembersCc</p>
							<ul id="record_container--request_for_information_recipients--Cc" style="list-style:none;">
							</ul>
						</div>
						<div>
							<p>Bcc: $ddlProjectTeamMembersBcc</p>
							<ul id="record_container--request_for_information_recipients--Bcc" style="list-style:none;">
							</ul>
						</div>
						<p>Add additional text to the body of the email: </p>
						<p>
							<textarea id="textareaEmailBody" class="RFI_table2"></textarea>
						</p>
						</td>
				</tr>

							
				<tr style="display:none;">
					<td class="RFI_table2_content" colspan="3">

					<p>
						<input type="button" style="font-size: 10pt;visibility:hidden;" class="savemail" onclick="SubcontractChangeOrderViaPromiseChain('$dummyId','2','1');" value="Save as SCO and Notify team">&nbsp;

							<input type="button" style="font-size: 10pt;visibility:hidden;"  class="savenoemail" onclick="SubcontractChangeOrderViaPromiseChain('$dummyId','2','0');" value="Save as SCO no email">&nbsp;

							$shoval&nbsp;
						
						</p>
						
						
						
						
						
					</td>
				</tr>
			</tbody></table>
		</div>
		<table style="width: 99%; border: 3px solid #d4d4d4;">
	   		<tr>
				<td class="CO_table_header2">Cost Analysis Breakdown</td>
			</tr>
			<tr>
				<td class="CO_table2_content">
				<div class="breakDiv">
						<div class="field_wrapper divtable divslides">
							<div class="trow">
								<div class="tcol"></div>
								<div class="tcol">DESCRIPTION</div>
								<div class="tcol"> SUB.	</div>
								<div class="tcol"> COST in ($)	</div>
								<div class="tcol">	</div>
							</div>
					$costanalysbreak
						<div class="divtable">
							<div class="trow">
								<div class="tcol" style="width: 6%;"></div>
								<div class="tcol" style="width: 12%;"></div>
								<div class="tcol" style="width: 2%;"><b>Update Subtotal : </b></div>
								<div class="tcol" style="width: 1%;">$</div>
								<div class="tcol" style="width: 10.5%;">
									<input type="text" class="Number"  name="subtotal" id="subtotal" value="$subtotal" disabled/>
									<input type="hidden" name="subhidden" id="subhidden" value="">
								</div> 
								<div class="tcol" style="width: 2%;" ></div> 
							</div>
						</div>
						<div class="cont_wrapper divtable contslides">
			        		$dyna_desp
			        	</div>
			          	<div class="divtable">
			          		<div class="trow">
			          			<div class="tcol" style="width: 9%;"></div>
								<div class="tcol" style="width: 9%;"></div>
								<div class="tcol" style="text-align: right;width: 2%;"><b>Total : </b></div>
								<div class="tcol" style="width: 1%;" >$</div>
								<div class="tcol" style="width: 10.5%;">
			          				<input type="text" class="Number" name="estamount" id="estamount" value="$estimated_amount" disabled/>
			          				<input type="hidden" class="Number" name="maintotal" id="maintotal" value="$estimated_amount"/> 
			          			</div>
			          			<div class="tcol" style="width: 1.5%;" ></div>
			          		</div>
			        	</div>
					</div>
				</td>
			</tr>   
	   </table>
	</div>
</form>



<input id="create-request_for_information-record--requests_for_information--request_for_information_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-request_for_information-record--requests_for_information--rfi_attachment_source_contact_id--$dummyId" type="hidden" value="$rfi_attachment_source_contact_id">
<input id="create-request_for_information-record--requests_for_information--rfi_creator_contact_id--$dummyId" type="hidden" value="$rfi_creator_contact_id">
<input id="create-request_for_information-record--requests_for_information--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-request_for_information-record--requests_for_information--dummy_id" type="hidden" value="$dummyId">
<input id="create-request_for_information-record--requests_for_information--sendNotification--$dummyId" type="hidden" value="false">
<input id="create-request_for_information_notification-record--request_for_information_notifications--request_for_information_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-request_for_information_recipient-record--request_for_information_recipients--request_for_information_notification_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-request_for_information_recipient-record--request_for_information_recipients--smtp_recipient_header_type--$dummyId" type="hidden" value="Cc">

<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_source_contact_id--$dummyId" type="hidden" value="$rfi_attachment_source_contact_id">
<input id="create-request_for_information_attachment-record--request_for_information_attachments--csvRfiFileManagerFileIds--$dummyId" type="hidden" value="$csvRfiFileManagerFileIds">


END_HTML_CONTENT;

	return $htmlContent;
}

//To get the subcontract those have final signed
function SubcontractFinalSignRegistry($database,$costcode,$user_company_id,$project_id,$order_subcontracts_id=null)
{
	$db = DBI::getInstance($database);
	$TransmittalTypes = array();
  	$query = "SELECT *,cc.id as comp_id,s.id as subcontractor_id,gc.id as gc_budget_id FROM `gc_budget_line_items` as gc
    inner join `subcontracts` as s on gc.id=s.gc_budget_line_item_id 
    inner join `vendors` as v on v.id=s.vendor_id 
    inner join `contact_companies` as cc on cc.id=v.vendor_contact_company_id 
     WHERE gc.`user_company_id` = $user_company_id AND gc.`project_id` = $project_id AND gc.`cost_code_id` = $costcode and s.unsigned_subcontract_file_manager_file_id!=''";
    $db->execute($query);
    $subOpt='<option value="">Select A Subcontractor</option>';
    $subcontracts_array=array();
     while($row = $db->fetch()){
     	$subcontracts_array[]=$row;
     }
     $count=count($subcontracts_array);
     $i=1;
     
  	 foreach ($subcontracts_array as $subcontracts) 
  		{
		   	$company = $subcontracts['company'];
		   	$comp_id = $subcontracts['comp_id'];
		   	$subcontractor_id = $subcontracts['subcontractor_id'];
		   	$gc_budget_id = $subcontracts['gc_budget_id'];
		   	$com_value=$comp_id.'~'.$subcontractor_id.'~'.$gc_budget_id;
		   	// if($comp_id == $subcontract_vendor_id || $count=='1')
		        if($subcontractor_id==$order_subcontracts_id || $count=='1')
		   	{
		   		$sel_opt="selected";
		   		
		   	}else
		   	{
		   		$sel_opt="";
		   	}
		   	if($count >1)
		   	{
		   		$company_data =$i.")".$company;
		   	}else
		   	{
		   		$company_data =$company;
		   	}
		   	$subOpt .="<option value=$com_value $sel_opt>$company_data</option>";
		   	$i++;
		}
		return $subOpt;
}

// To get All RFIs of a project
	function loadopenRFIRegistry($database,$project_id){
		$db = DBI::getInstance($database);
		$Rfiarr = array();
        $query = "SELECT * FROM `requests_for_information` WHERE `project_id` = '$project_id' ORDER BY `rfi_sequence_number` Desc ";
        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$val ='RFI#'.$row['rfi_sequence_number'].' - '.$row['rfi_title'];
		   	$key = $row['id'];
		   	$Rfiarr[$key] = $val;
		}
		return $Rfiarr;

	}

	// To get All EXPOSURE ITEMS
	function loadExposureRegistry($database){
		$db = DBI::getInstance($database);
		$Expoarr = array();
        $query = "SELECT * FROM `exposure_items` WHERE `disabled_flag` = 'N' ORDER BY `id` ASC ";
        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$val = $row['exposure_item_type'];
		   	$key = $row['id'];
		   	$Expoarr[$key] = $val;
		}
		return $Expoarr;

	}
	//To get the attachments
	function AttachmentSuborderRegistry($subid, $database)
	{
		$db = DBI::getInstance($database);
		$attachmentQuery = "SELECT s.attachment_file_manager_file_id, f.virtual_file_name , s.is_executed FROM file_manager_files as  f JOIN subcontract_change_order_attachments s  ON f.id = s.attachment_file_manager_file_id  WHERE s.suborder_id='$subid' and s.is_executed='Y'";
		$db->query($attachmentQuery);
		$attachmentRecords = array();
		while($attachmentRow = $db->fetch())
		{
			$attachmentRecords[] = $attachmentRow;
		}
		$attach = [];
		$count = count($attachmentRecords);		
		$attachmentHtml = "<ul id='sub_order_$subid' style='list-style:none; margin:0; padding:0'>";
		foreach($attachmentRecords as $attachmentRecord){
			$attachmentId = $attachmentRecord['attachment_file_manager_file_id'];
			$attachmentName = $attachmentRecord['virtual_file_name'];
			$value = $attachmentId;
			$FileManagerFile = FileManagerFile::findById($db, $attachmentId);
			$attachmentId = $FileManagerFile->generateUrl();
			$attachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="drop-inner"><a target="_blank" href="'.$attachmentId.'" style="float: left;padding-left: 5px;padding-top: 5px;">'.$attachmentName.'</a></li>';
		}
		$attachmentHtml .= '</ul>';
		$attach['count'] = $count;
		$attach['files'] = $attachmentHtml;
		return $attach;
	}

	function calculateEstimatedAmountSubtotalRegistry($cost_id,$projectId, $database,$checkpotential)
	{
		if($checkpotential =='Y')
		{
			$status ="and status !='rejected' ";
		}else
		{
			$status ="and status !='rejected' And status ='approved'";
		}
		$db = DBI::getInstance($database);
		$query1 = "SELECT sum(estimated_amount) as total FROM `subcontract_change_order_data` WHERE `costcode_id` = '$cost_id' and `project_id`= '$projectId' $status";

        $db->execute($query1);
		$row1 = $db->fetch();
		$total=$row1['total'];
		return $total;
	}
	// to calculate the subcontractor total for subcontractor view
	function calculateSubtotalForSubcontractViewRegistry($sub_id,$projectId, $database,$checkpotential)
	{
		if($checkpotential =='Y')
		{
			$status ="and status !='rejected' ";
		}else
		{
			$status ="and status !='rejected' And status ='approved'";
		}
		$db = DBI::getInstance($database);
		$query1 = "SELECT sum(estimated_amount) as total FROM `subcontract_change_order_data` WHERE `subcontract_vendor_id` = '$sub_id' and `project_id`= '$projectId' $status";

        $db->execute($query1);
		$row1 = $db->fetch();
		$total=$row1['total'];
		return $total;
	}
	// To get the count to display the subcontractor total in subcontractor view
	function DisplaySubtotalInSubViewRegistry($sub_id,$project_id, $database,$checkpotential)
	{
		if($checkpotential =='Y')
		{
			$status ="and status !='rejected' ";
		}else
		{
			$status ="and status !='rejected' And status ='approved'";
		}
		$db = DBI::getInstance($database);
		$query1 = "SELECT count(*) as count FROM `subcontract_change_order_data` WHERE `subcontract_vendor_id` = '$sub_id' and `project_id`='$project_id' $status"; 
        $db->execute($query1);
		$row1 = $db->fetch();
		$count=$row1['count'];
		return $count;
	}
	//To get the view totals
	function DisplayviewTotalRegistry($cost_id,$project_id, $database,$checkpotential)
	{
		if($checkpotential =='Y')
		{
			$status ="and status !='rejected' ";
		}else
		{
			$status ="and status !='rejected' And status ='approved'";
		}
		$db = DBI::getInstance($database);
		$query1 = "SELECT count(*) as count FROM `subcontract_change_order_data` WHERE `costcode_id` = '$cost_id' and `project_id`='$project_id' $status"; 
        $db->execute($query1);
		$row1 = $db->fetch();
		$count=$row1['count'];
		return $count;
	}
	// status position for costcode view
	function checkstatusPositionRegistry($cost_id,$project_id,$status, $database)
	{
		
		$db = DBI::getInstance($database);
		$query1 = "SELECT count(*) as count ,sum(estimated_amount) as estimated_amount FROM `subcontract_change_order_data`  where `project_id` = $project_id and  `costcode_id`=$cost_id and `status` IN ($status) ";

        $db->execute($query1);
		$row1 = $db->fetch();
		$count=$row1['count'];
		$estimated_amount=Format::formatCurrency($row1['estimated_amount']);
		
		$arrReturn = array(
			'count' => $count,
			'estimated_amount' => $estimated_amount
		);

		return $arrReturn;
	}
	// To get the Subcontrator total against a costcode and no of rows
	function subcontractTotalAndCountAgainstCostcodeRegistry($database,$cost_id,$project_id,$status,$subcontract_vendor_id)
	{
		$db = DBI::getInstance($database);
		$query1 = "SELECT count(*) as count ,sum(estimated_amount) as estimated_amount FROM `subcontract_change_order_data`  where `project_id` = $project_id and  `costcode_id`=$cost_id and `status` IN ($status) and subcontract_vendor_id =$subcontract_vendor_id ";

        $db->execute($query1);
		$row1 = $db->fetch();
		$count=$row1['count'];
		$estimated_amount=Format::formatCurrency($row1['estimated_amount']);
		
		$arrReturn = array(
			'count' => $count,
			'estimated_amount' => $estimated_amount
		);

		return $arrReturn;
	}
	//To get the Overall status total 
	function OverallstateTotalRegistry($project_id,$status, $database)
	{
		$db = DBI::getInstance($database);
		$query1 = "SELECT count(*) as count ,sum(estimated_amount) as estimated_amount FROM `subcontract_change_order_data`  where `project_id` = $project_id and `status` IN ('$status') ";

        $db->execute($query1);
		$row1 = $db->fetch();
		$count=$row1['count'];
		$estimated_amount=Format::formatCurrency($row1['estimated_amount']);
		
		$stateReturn = array(
			'count' => $count,
			'estimated_amount' => $estimated_amount
		);
		return $stateReturn;
	}

	// status position for subcontractor view
	function subcontractorcheckstatusPositionRegistry($cost_id,$project_id,$status,$subcontract_vendor_id, $database)
	{
		
		$db = DBI::getInstance($database);
		$query1 = "SELECT count(*) as count ,sum(estimated_amount) as estimated_amount FROM `subcontract_change_order_data`  where `project_id` = $project_id and  `costcode_id`=$cost_id and `status` IN ($status)and `subcontract_vendor_id`=$subcontract_vendor_id ";

        $db->execute($query1);
		$row1 = $db->fetch();
		$count=$row1['count'];
		$estimated_amount=Format::formatCurrency($row1['estimated_amount']);
		
		$arrReturn = array(
			'count' => $count,
			'estimated_amount' => $estimated_amount
		);

		return $arrReturn;
	}

	//To fetch the file URL for SCO 
	function fetchSCOFileURLRegistry($database,$file_id)
	{

		$scoPdfUrl="";
		if (isset($file_id) && !empty($file_id)) {
			$scoFileManagerFile = FileManagerFile::findById($database, $file_id);
			if(!empty($scoFileManagerFile))
			{
				$scoPdfUrl = $scoFileManagerFile->generateUrl();
			}
		}
		return $scoPdfUrl;
	}

	function getSCOFieldDataRegistry($database,$subChange_id,$fieldname)
	{
		$db = DBI::getInstance($database);
		$app_pre ="";
    	//To get the appr id
		$que ="SELECT $fieldname  FROM `subcontract_change_order_data` WHERE `id` = '$subChange_id' ";
		$db->execute($que);
		$row = $db->fetch();
		$app_pre = $row[$fieldname];
		$db->free_result();
		return $app_pre;
	}
    // To get the cost breakdown data
    function getSCOcostbreakdownDataRegistry($database,$sco_id)
	{
		
		$db = DBI::getInstance($database);
		 $Query = "SELECT * FROM subcontract_change_order_cost_break   WHERE subcontract_change_order_id=? AND cost_code_flag='1'";
        $arrValues = array($sco_id);
		$db->execute($Query, $arrValues, MYSQLI_USE_RESULT);

		$resultdata=array();
		while($row = $db->fetch())
		{
			$resultdata[] = $row;
		}
		$db->free_result();		
		return $resultdata;
	}

	function getSCOtaxDataRegistry($database,$sco_id)
	{
		
		$db = DBI::getInstance($database);
		 $Query = "SELECT * FROM subcontract_change_order_tax_break   WHERE subcontract_change_order_id=?";
		$arrValues = array($sco_id);
		$db->execute($Query, $arrValues, MYSQLI_USE_RESULT);
		$resultdata=array();
		while($row = $db->fetch())
		{
			$resultdata[] = $row;
		}
		$db->free_result();
		return $resultdata;
	}