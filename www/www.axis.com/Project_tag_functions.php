<?php


$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

/**
* Display the tags Grid
* @param project id
* @return html
*/
function renderTagsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch)
{	
	$TagTableTbody = '';
	$incre_id=1;
	$db = DBI::getInstance($database);
	$query = "SELECT * FROM `tagging` where project_id = '$project_id' order by  id";
	$db->execute($query);
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$ic='1';
	if($records)
	{
	foreach($records as $row)
	{
		$tag_name      = $row['tag_name'];
		$tag_id 	= $row['id'];
		

		//To check whether the tag mapped  in RFI and submittal or not
		$TagResult=checkTagExistInSubOrRFI($database,$tag_id,$project_id);
		if($TagResult =="1")
		{
			$funfortagdelete ="existTagwarn('$tag_id');";
		}else
		{
			$funfortagdelete ="DelTagconfirm('$tag_id');";
		}
		
		$tag_name = str_replace('\'', '&apos;',$tag_name);
   		$TagTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-tagging-record--$tag_id" class="row_$tag_id list-row " style="cursor:pointer;" >
			
			<td>
			<span id="prime-text-$tag_id" class="tag_name--$tag_id  unit-text" style="display:block;align:center;">$tag_name</span>

			<input id="manage-tagging-record--tagging_data--tag_name--$tag_id" class=" unit-edit tag_name_$tag_id" type="text" value='$tag_name'  onchange="Tag_update(this.id,this.value, '$tag_id');"  style="display:none;">
			</td>


			
			<td class="textAlignCenter" id="manage-tagging-record--" ><span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="$funfortagdelete" title="Delete Tag">&nbsp;</span> </td>
			</tr>

END_DELAYS_TABLE_TBODY;
		$incre_id++;
		}
	}else
	{
		$TagTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr ><td colspan='4'>No Data Available</td></tr>
END_DELAYS_TABLE_TBODY;

	}
	$htmlContent = <<<END_HTML_CONTENT
	<div>
	<table id="buildingtblTabularData" class="potential-grid table-suborder-view sub_selectST" border="$border" cellpadding="5" style="border-collapse:collapse;" width="80%">
		<thead>
		<tr class="permissionTableMainHeader">
		<th width="20%">
		<div style="margin:0 auto;width: 50%;overflow: hidden;"><span style="float:left;">Tags
		</span>
		<span id="entypo-edit-icon" class="entypo-click" style="display:block;float:left;margin-left:10px;" onclick="allowToUserEditTags(true);">
		<img src="images/edit-icon.png"></img>

		</span>
		<span  id="entypo-lock-icon" class="entypo-click" style="display:none;float:left;margin-left:10px;" onclick="allowToUserEditTags(false);">
		<span class="entypo-lock"></span>
		</span>
		</div>
		</th>
	
		<th width="5%" class="">Action</th>
		</tr>
	</thead>
	<tbody class="">
		$TagTableTbody
	</tbody>
</table>
</div>

END_HTML_CONTENT;


	return $htmlContent;
}

//To check whether the tag mapped with RFI por Submittal or not

function checkTagExistInSubOrRFI($database,$id,$project_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query1 = "SELECT id,tag_ids FROM `requests_for_information` where FIND_IN_SET ('$id', tag_ids) and project_id ='$project_id' union SELECT id,tag_ids FROM `submittals` where FIND_IN_SET ('$id', tag_ids) and project_id ='$project_id' ";
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


//To delete Tags
function deleteTags($database,$tag_id)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "DELETE From tagging where id='$tag_id'";
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
//To Update Tag name
function updateTagName($tag_id,$tag_name)
{
	$db = DBI::getInstance($database);  // Db Initialize
	$query = "UPDATE `tagging` SET `tag_name`= ? WHERE id = ?";
	$array1 = array($tag_name,$tag_id);
	$db->execute($query,$array1);
    $db->free_result();
    return '1';
}
