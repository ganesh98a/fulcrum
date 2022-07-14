<?php
$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/PageComponents.php');
require_once('lib/common/Draws.php');
require_once('lib/common/DrawItems.php');
require_once('lib/common/DrawStatus.php');
require_once('lib/common/DrawSignatureType.php');
require_once('lib/common/DrawSignatureBlocks.php');

require_once('lib/common/DrawSignatureBlocksConstructionLender.php');
require_once('lib/common/Project.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/ContractingEntities.php');
require_once('app/models/accounting_model.php');
require_once('lib/common/RetentionDraws.php');
require_once('lib/common/RetentionSignatureBlocks.php');
require_once('lib/common/RetentionSignatureBlocksConstructionLender.php');

// Draw Signature Block Content
function renderSignatureBlockContent($database, $project_id, $draw_id,$type=''){

  $session = Zend_Registry::get('session');
  $user_company_id = $session->getUserCompanyId();
  $debugMode = $session->getDebugMode();
  $project = Project::findById($database, $project_id);
  if($debugMode){
    $debug_mode_param = $debugMode;
  }else {
    $debug_mode_param = 0;   
  }

  /* Customer-Project Dropdown - start */
  $projectCustArr = getProjectCustomers($database,$user_company_id);
 

  /* Customer-Project Dropdown - End */
  
  $drawData = Draws::findById($database, $draw_id); 

  $drawStatus = $drawData['status'];
  $isDrawDisbaled = false;
  $disabled = '';
  $hideButtonForPosted = '';
  if($drawStatus >= 2){
    $isDrawDisbaled = true;
    $disabled = 'disabled="disabled"';
    $hideButtonForPosted = 'displayNone';
  }
  
  
  /* Contracting Entity -- Start */
  $qb_customer_sel_id = $drawData['qb_customer_id'];
  if($qb_customer_sel_id ==0)
  {
    $prevApplication = $drawData['application_number']-1;
     $prevcustomer_id = Draws::getPrevAppQbCutomerId($database,$project_id, $prevApplication); 
     $qb_customer_sel_id = $prevcustomer_id;
  }
  $qb_cust_html = "<select id='project_customer' name='project_customer' class='moduleProjectInformationDropdown required' style='width: 170px;' $disabled>
                      <option value=''>Select a QB Customer</option>
                   ";
  foreach($projectCustArr as $qb_customer_id => $qb_customer){
    $qb_cust_selected = '';
    if(!empty($qb_customer_sel_id) && $qb_customer_id == $qb_customer_sel_id){
      $qb_cust_selected = 'selected';
    }
    $qb_cust_html .= "<option value='".$qb_customer."' ".$qb_cust_selected.">".$qb_customer."</option>";
  }

  $qb_cust_html .=  "</select>";

  $contractingEntityName = '';
  if(!empty($drawData['contracting_entity_id'])){
    $contractingEntityName =  ContractingEntities::getcontractEntityNameforProject($database,$drawData['contracting_entity_id']);
  }
  
  /* Contracting Entity -- End */
  $projectOwnerName = $project->project_owner_name;
  $userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $project->user_company_id);
  // /* @var $userCompany UserCompany */
  $userCompanyName = $userCompany->user_company_name;
  // get all signature Types
  $loadSignatureTypeOptions = new Input();
  $loadSignatureTypeOptions->forceLoadFlag = true;

  
  $arrSignatureTypeArr = DrawSignatureType::loadAllDrawSignatureType($database, $loadSignatureTypeOptions);
  $signatureTypeBlockHtml = '';
  foreach($arrSignatureTypeArr as $signatureTypeId => $signatureTypes) {
  	// get signature block id
	$loadSignatureBlockOptions = new Input();
	$loadSignatureBlockOptions->forceLoadFlag = true;
	$loadSignatureBlockOptions->arrOrderByAttributes = array(
		'dsb.`id`' => 'ASC'
	);

    $signatureBlockArr = DrawSignatureBlocks::findByDrawSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
 
  
	$otherCount = 0;
	if($signatureTypeId == 6){
		$otherCount = count($signatureBlockArr);
		if($otherCount == 0){
			$otherCount = 1;
		}
	}
  // to get the architect company and architect name
  $Projdetails = Project::findById($database, $project_id);
  $architectCmpyNameRaw = ContactCompany::findByContactUserCompanyId($database, $Projdetails['architect_cmpy_id']);
  $contactName = Contact::findById($database, $Projdetails['architect_cont_id']);
  $architectContNameRaw = ($contactName == '') ? '' : $contactName->getContactFullName();
  $architectName = $architectCmpyNameRaw .":".$architectContNameRaw;

	$updatedDescflag = 'N';
	if(isset($signatureBlockArr) && !empty($signatureBlockArr)) {
		$counti = 0;
		foreach($signatureBlockArr as $signature_block_id => $signatureBolck) {
			if($counti > 0){
				break;
			}
			$signatureBlockId = $signatureBolck->signature_block_id;
			$enable_flag = $signatureBolck->enable_flag;
			$description = $signatureBolck->signature_block_description;
			$updatedDescflag = $signatureBolck->signature_block_desc_update_flag;
			$counti++;
		}
		if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
			$description = $contractingEntityName;
		}
		if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
			$description = $projectOwnerName;
		}
    if($updatedDescflag == 'N' && ($signatureTypeId == 3)){
      $description = $architectName;
    }
     
		if($enable_flag == 'Y') {
			$enable_flag = 'checked=checked';
		} else {
			$enable_flag = '';
		}
	} else {
		$description = '';
		if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
			$description = $contractingEntityName;
		}
		if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
    	$description = $projectOwnerName;
		}
    if($updatedDescflag == 'N' && ($signatureTypeId == 3)){
      $description = $architectName;
    }
		$signatureBlockId = 0;

		$enable_flag = '';
	}

  	$jsArray = array(
  		'signatureTypeId' => intVal($signatureTypeId),
  		'projectId' => intVal($project_id),
  		'drawId' => intVal($draw_id),
  		'signatureBlockId' => intVal($signatureBlockId)
  	);
  	$jsOptionJson = json_encode($jsArray);
    $signatureTypeBlockHtmlInput = '';
    $uniqueId = $signatureTypes->signature_type_entity."1";
    $uniqueId =str_replace(' ','_',$uniqueId);
    $signType = str_replace(' ','_',$signatureTypes->signature_type_entity);
    $readOnly = '';
    $readOnlyClass = '';
    $borderRedClass = '';
    $displayNoneClass = 'displayNone';
    if ($enable_flag == ''){
    	$readOnly = 'readonly="readonly"';
    	$readOnlyClass = 'readOnly';
    } else {
    	$displayNoneClass = '';
    }
    if ($enable_flag != '' && ( $description == '' || $description == NULL)){
    	$borderRedClass = 'redBorder';
    	$displayNoneClass = '';
    }
    if($signatureTypes->signature_type_default_editable_flag == 'Y' && $signatureTypeId != 5 && $signatureTypeId != 2 && $signatureTypeId != 1 && $signatureTypeId != 3) {
      if($isDrawDisbaled){
        $descriptionHtml = $description;
      }else{
        $descriptionHtml = <<<DESCRIPTION_HTML
        <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' class="$readOnlyClass $borderRedClass" type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
      }
      $signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
      <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
      $descriptionHtml
SIGNATURETYPEBLOCKHTML;
    } else     if($signatureTypes->signature_type_default_editable_flag == 'Y' && ($signatureTypeId == 2 || $signatureTypeId == 1 || $signatureTypeId == 3)) {
        if($isDrawDisbaled){
          $descriptionHtml = '';
        }else{
          $descriptionHtml = <<<DESCRIPTION_HTML
          <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' class="$readOnlyClass $borderRedClass" type="hidden" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
        }
        if(!empty($type) && $type == "Retention"){
          $descriptionHtml = <<<DESCRIPTION_HTML
          <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' type="hidden" value="$description" />
DESCRIPTION_HTML;
        }
        $signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
        <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
        $descriptionHtml
        $description
SIGNATURETYPEBLOCKHTML;
    } else {
    	if($signatureTypes->signature_type_default_editable_flag == 'Y') {

        if($isDrawDisbaled){
          $descriptionHtml = $description;
        }else{
          $descriptionHtml = <<<DESCRIPTION_HTML
        <input class="$displayNoneClass $uniqueId $readOnlyClass $borderRedClass" id='manage_draw--signature_name--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
        }

    		$signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
		      <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
           $descriptionHtml
SIGNATURETYPEBLOCKHTML;
    	}
    }
    $signatureTypeBlockHtmlInputCLTR = '';

    if($signatureTypeId == 5) {
      // get Signature block CL (Construction Lender)
      $loadSignatureBlockCLOptions = new Input();
	  $loadSignatureBlockCLOptions->forceLoadFlag = true;
      $arrSBCL = DrawSignatureBlocksConstructionLender::loadDrawSignatureBlocksCLBySBId($database, $signatureBlockId, $loadSignatureBlockCLOptions);
      $address1 = '';
      $address2 = '';
      $city_state_zip = '';
      $sb_cl_id = 0;
      $address1RedBorderClass = '';
	  $address2RedBorderClass = '';
	  $cityRedBorderClass = '';
      if(isset($arrSBCL) && !empty($arrSBCL)) {
      		$sb_cl_id = $arrSBCL->signature_block_construction_lender_id;
      		$address1 = $arrSBCL->signature_block_construction_lender_address_1;
      		$address2 = $arrSBCL->signature_block_construction_lender_address_2;
      		$city_state_zip = $arrSBCL->signature_block_construction_lender_city_state_zip;
      }
      if($address1 == '' || $address1 == NULL ){
      	$address1RedBorderClass = 'redBorder';
      }
      if($address2 == '' || $address2 == NULL ){
      	$address2RedBorderClass = 'redBorder';
      }
      if($city_state_zip == '' || $city_state_zip == NULL ){
      	$cityRedBorderClass = 'redBorder';
      }

      if($isDrawDisbaled){
        $address1Html = $address1;
        $address2Html = $address2;
        $cityHtml = $city_state_zip;
      }else{
        $address1Html = <<<ADDRESS_ONE_HTML
        <input class='$address1RedBorderClass' id='manage_draw--signature_address1--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlockCL(this, "manage_draw--signature_address1", "$uniqueId", $jsOptionJson)' value="$address1" />
ADDRESS_ONE_HTML;

        $address2Html = <<<ADDRESS_ONE_HTML
        <input class='$address2RedBorderClass' id='manage_draw--signature_address2--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlockCL(this, "manage_draw--signature_address2", "$uniqueId", $jsOptionJson)' type="text" value="$address2" />
ADDRESS_ONE_HTML;

        $cityHtml = <<<ADDRESS_ONE_HTML
        <input class='$cityRedBorderClass' id='manage_draw--signature_city--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlockCL(this, "manage_draw--signature_city", "$uniqueId", $jsOptionJson)' type="text" value="$city_state_zip" />
ADDRESS_ONE_HTML;
      }
      $signatureTypeBlockHtmlInputCLTR = <<<SIGNATURETYPEBLOCKHTML
      <tr class="$displayNoneClass $uniqueId" id='record_container--manage_draw----$signatureTypeId'>
        <td><input type="hidden" id='manage_draw--signature_cl_id--$uniqueId--$signatureTypeId' value="$sb_cl_id"/></td>
        <td>Address 1:</td>
        <td colspan="2">$address1Html</td>
      </tr>
      <tr class="$displayNoneClass $uniqueId" id='record_container--manage_draw----$signatureTypeId'>
        <td></td>
        <td>Address 2:</td>
        <td colspan="2">$address2Html</td>
      </tr>
      <tr class="$displayNoneClass $uniqueId trBorderBottom" id='record_container--manage_draw----$signatureTypeId'>
        <td></td>
        <td>City,State,Zip:</td>
        <td colspan="2">$cityHtml</td>
      </tr>
SIGNATURETYPEBLOCKHTML;
    }
    $trBorderBottomCls = '';
    $trBorderBottomIn ='';
    if($signatureTypeId != 5){
    	if($trBorderBottomIn == 0) {
    		$trBorderBottomCls = 'trBorderBottom';
    	} else {
    		$trBorderBottomCls = 'trBorderBottom trBorderTop';
    	}
    	$trBorderBottomIn = 0;
    } else {
    	$trBorderBottomIn = 1;
    }

    $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
    <tr class="$trBorderBottomCls" id='record_container--manage_draw--draw_signature_type--$signatureTypeId'>
SIGNATURETYPEBLOCKHTML;
    if($debugMode){
      $html_signature_type_id =  (!empty($signatureTypeId) ? $signatureTypeId : '&nbsp;');
      $html_signature_block_id =  (!empty($signatureBlockId) ? $signatureBlockId : '&nbsp;');
      $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
      <td class="text-center">$html_signature_type_id</td>
      <td class="text-center">$html_signature_block_id</td>
SIGNATURETYPEBLOCKHTML;
    }
  $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
      <td id='manage_draw--draw_signature_type--include' class="text-center">
      <input type="hidden" id='manage_draw--signature_block_count--$uniqueId--$signatureTypeId' value="$otherCount"/>
      <input type="hidden" id='manage_draw--signature_block_type--$uniqueId--$signatureTypeId' value="$signType"/>
      <input type="hidden" id='manage_draw--signature_block_id--$uniqueId--$signatureTypeId' onchange='onClickIncludeBlock(this, "manage_draw--signature_block_id", "$uniqueId", $jsOptionJson)' value="$signatureBlockId"/>
      <input type="checkbox" $enable_flag $disabled id='manage_draw--signature_include--$uniqueId--$signatureTypeId' onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlock(this, "manage_draw--signature_include", "$uniqueId", $jsOptionJson)'/></td>
      <td>$signatureTypes->signature_type_entity:</td>
      <td colspn="2">$signatureTypeBlockHtmlInput</td>
    </tr>
    $signatureTypeBlockHtmlInputCLTR
SIGNATURETYPEBLOCKHTML;
      if(!empty($signatureTypeId) && $signatureTypeId == 2 ) {
        $qb_customer_sel = '<tr class="trBorderBottom">';
        if($debugMode){
            $qb_customer_sel .= '<td></td>
                        <td class="text-center">'.$qb_customer_sel_id.'</td>';
        }
        if ($isDrawDisbaled) {
        $qb_customer_sel .= '
            <td style="vertical-align:top; text-align: center;"><a title="Click to Check Availability & get Project Customer from QB"><img src="/images/refresh_icon.png" style="height:25px; width:25px;" ></a></td>';
        }else{
        $qb_customer_sel .= '
            <td style="vertical-align:top; text-align: center;"><a href="javaScript:void(0);" id="checkindicator" title="Click to Check Availability & get Project Customer from QB"><img src="/images/refresh_icon.png" style="height:25px; width:25px;" ></a></td>';
        }

        $qb_customer_sel .= '<td class="fields red-text current_indicator"><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB"> Customer:Project </td>
            <td colspan="2" >'.$qb_cust_html.'</td>
          </tr>';
        $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
              $qb_customer_sel
SIGNATURETYPEBLOCKHTML;
       
        
  }
  	//  other more than 2
  	// get signature block id
	$loadSignatureBlockOptions = new Input();
	$loadSignatureBlockOptions->forceLoadFlag = true;
	$loadSignatureBlockOptions->arrOrderByAttributes = array(
		'dsb.`id`' => 'ASC'
	);
	$signatureBlockArr = DrawSignatureBlocks::findByDrawSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
	if(isset($signatureBlockArr) && !empty($signatureBlockArr)) {
		$counti = 0;
		foreach($signatureBlockArr as $signature_block_id => $signatureBolck) {
			if($counti == 0){
				$counti++;
				continue;
			}
			$signatureBlockId = $signatureBolck->signature_block_id;
			$enable_flag = $signatureBolck->enable_flag;
			$description = $signatureBolck->signature_block_description;
			$updatedDescflag = $signatureBolck->signature_block_desc_update_flag;

			if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
				$description = $userCompanyName;
			}
			if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
				$description = $projectOwnerName;
			}
       if($updatedDescflag == 'N' && ($signatureTypeId == 3)){
      $description = $architectName;
    }
			if($enable_flag == 'Y') {
				$enable_flag = 'checked=checked';
			} else {
				$enable_flag = '';
			}
			$jsArray = array(
				'signatureTypeId' => intVal($signatureTypeId),
				'projectId' => intVal($project_id),
				'drawId' => intVal($draw_id),
				'signatureBlockId' => intVal($signatureBlockId)
			);
			$jsOptionJson = json_encode($jsArray);
			$signatureTypeBlockHtmlInput = '';
			$uniqueId = $signatureTypes->signature_type_entity.($counti+1);
			$uniqueId =str_replace(' ','_',$uniqueId);
			$readOnly = '';
			$readOnlyClass = '';
			$borderRedClass = '';
			if ($enable_flag == ''){
				$readOnly = 'readonly="readonly"';
				$readOnlyClass = 'readOnly';
			} else {
				$displayNoneClass = '';
			}
			if ($enable_flag != '' && ( $description == '' || $description == NULL)){
				$borderRedClass = 'redBorder';
				$displayNoneClass = '';
			}
			if($signatureTypes->signature_type_default_editable_flag == 'Y' && $signatureTypeId != 5) {
        if($isDrawDisbaled){
          $descriptionHtml = $description;
        }else{
          $descriptionHtml = <<<DESCRIPTION_HTML
          <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' class="$readOnlyClass $borderRedClass" type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
        }
				$signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
				<input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
           $descriptionHtml
SIGNATURETYPEBLOCKHTML;
			}
      if($debugMode){
        $html_signature_type_id =  (!empty($signatureTypeId) ? $signatureTypeId : '&nbsp;');
        $html_signature_block_id =  (!empty($signatureBlockId) ? $signatureBlockId : '&nbsp;');
        $signatureTypeBlockDebugHtml = <<<SIGNATURETYPEBLOCKDEBUGHTML
        <td class="text-center">$html_signature_type_id</td>
        <td class="text-center">$html_signature_block_id</td>
SIGNATURETYPEBLOCKDEBUGHTML;
      }else{
        $signatureTypeBlockDebugHtml = '';
      }
			$signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
			<tr id='record_container--removable_draw--$uniqueId--$signatureTypeId'>
      $signatureTypeBlockDebugHtml
			<td id='manage_draw--draw_signature_type--include' class="text-center">
			<input type="hidden" id='manage_draw--signature_block_id--$uniqueId--$signatureTypeId' onchange='onClickIncludeBlock(this, "manage_draw--signature_block_id", "$uniqueId", $jsOptionJson)' value="$signatureBlockId"/>
			<input type="checkbox" $enable_flag $disabled id='manage_draw--signature_include--$uniqueId--$signatureTypeId' onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeBlock(this, "manage_draw--signature_include", "$uniqueId", $jsOptionJson)'/></td>
			<td>$signatureTypes->signature_type_entity:</td>
			<td>$signatureTypeBlockHtmlInput</td>
			<td><a class="cursorPoint $hideButtonForPosted" onclick="removeRowSB(&quot;record_container--removable_draw&quot;,&quot;manage_draw--signature_block_id&quot;, &quot;$uniqueId&quot;,&quot;$signatureTypeId&quot;,$debug_mode_param)"><span class="entypo-cancel-circled"></span></a></td>
			</tr>
SIGNATURETYPEBLOCKHTML;


        }
			$counti++;
		}

	}
  if($debugMode){
    $debugHeadline =
     '<th><span class="textColorWhite">SIGNATURE<br>TYPE<br>ID</span></th>
      <th><span class="textColorWhite">SIGNATURE<br>BLOCK<br>ID</span></th>';
  } else {
    $debugHeadline = '';
  }

  // end more than
  $drawHtmlContent = <<<DrawBlockContent
  <table class="drawSignatureBlockTable">
    <thead>
      <tr class="backgroundColorBlue">
        $debugHeadline
        <th><span class="textColorWhite">Include?</span></th>
        <th class="text-left"><span class="textColorWhite">Entity</span></th>
        <th colspan="2"><span class="textColorWhite">Name</span></th>
      </tr>
    </thead>
    <tbody id="signatureTableContentBody">
      $signatureTypeBlockHtml
    </tbody>
  </table>
  <table style="width:100%;">
    <tbody>
      <tr>
        <td><button type="button" class="btn btn-primary btn-cmn $hideButtonForPosted" onclick="addOthersNewRow('manage_draw','$uniqueId', $signatureTypeId, $draw_id, $project_id, $debug_mode_param)">Add</button></td>
        <td></td>
        <td>
          <div class="fields">
            <ul>
              <li class="tasksummary">
              <span class="indicator green-box"></span>
              <b>Exist</b>
              </li>
              <li class="tasksummary">
              <span class="indicator red-box"></span>
              <b>Not Exist</b>
              </li>
            </ul>
          </div>

        </td>
      </tr>
    </tbody>
  </table>
DrawBlockContent;
  return $drawHtmlContent;
}

// Draw Signature Block Content
function renderRetentionSignatureBlock($database, $project_id, $draw_id,$type=''){

  $session = Zend_Registry::get('session');
  $user_company_id = $session->getUserCompanyId();
  $debugMode = $session->getDebugMode();
  $project = Project::findById($database, $project_id);
  if($debugMode){
    $debug_mode_param = $debugMode;
  }else {
    $debug_mode_param = 0;   
  }

  /* Customer-Project Dropdown - start */
  $projectCustArr = getProjectCustomers($database,$user_company_id);
 

  /* Customer-Project Dropdown - End */
 
  $drawData = RetentionDraws::findById($database, $draw_id);

  $drawStatus = $drawData['status'];
  $isDrawDisbaled = false;
  $disabled = '';
  $hideButtonForPosted = '';
  if($drawStatus >= 2){
    $isDrawDisbaled = true;
    $disabled = 'disabled="disabled"';
    $hideButtonForPosted = 'displayNone';
  }
  
  
  /* Contracting Entity -- Start */
  $qb_customer_sel_id = $drawData['qb_customer_id'];
  $prevcustomer_id=0;
  if($qb_customer_sel_id ==0){
    $prevApplication = $drawData['application_number']-1;
    $prevcustomer_id = RetentionDraws::getPrevAppQbCutomerId($database,$project_id, $prevApplication); 
    $qb_customer_sel_id = $prevcustomer_id;
  }


  if($prevcustomer_id==0){
    $prevApplication = $drawData['application_number']-1;
    $prevcustomer_id = RetentionDraws::getFirstAppQbCutomerId($database,$project_id, $prevApplication); 

    $qb_customer_sel_id = $prevcustomer_id;
  }
  
  $qb_cust_html = "<select id='project_customer_retention' name='project_customer' class='moduleProjectInformationDropdown required' style='width: 170px;' $disabled>
                      <option value=''>Select a QB Customer</option>
                   ";
  foreach($projectCustArr as $qb_customer_id => $qb_customer){
    $qb_cust_selected = '';
    if(!empty($qb_customer_sel_id) && $qb_customer_id == $qb_customer_sel_id){
      $qb_cust_selected = 'selected';
    }
    $qb_cust_html .= "<option value='".$qb_customer."' ".$qb_cust_selected.">".$qb_customer."</option>";
  }

  $qb_cust_html .=  "</select>";

  $contractingEntityName = '';
  if(!empty($drawData['contracting_entity_id'])){
    $contractingEntityName =  ContractingEntities::getcontractEntityNameforProject($database,$drawData['contracting_entity_id']);
  }
  
  /* Contracting Entity -- End */
  $projectOwnerName = $project->project_owner_name;
   // to get the architect company and architect name
  $Projdetails = Project::findById($database, $project_id);
  $architectCmpyNameRaw = ContactCompany::findByContactUserCompanyId($database, $Projdetails['architect_cmpy_id']);
  $contactName = Contact::findById($database, $Projdetails['architect_cont_id']);
  $architectContNameRaw = ($contactName == '') ? '' : $contactName->getContactFullName();
   $architectName = $architectCmpyNameRaw .":".$architectContNameRaw;
  $userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $project->user_company_id);
  // /* @var $userCompany UserCompany */
  $userCompanyName = $userCompany->user_company_name;
  // get all signature Types
  $loadSignatureTypeOptions = new Input();
  $loadSignatureTypeOptions->forceLoadFlag = true;
  if(!empty($type) && $type == "Retention"){ // To ignore the notary block
    $loadSignatureTypeOptions->filter = $type;
  }
  
  $arrSignatureTypeArr = DrawSignatureType::loadAllDrawSignatureType($database, $loadSignatureTypeOptions);
  // echo "<pre>type";
  // print_r($arrSignatureTypeArr);
  $signatureTypeBlockHtml = '';
  foreach($arrSignatureTypeArr as $signatureTypeId => $signatureTypes) {
    // get signature block id
  $loadSignatureBlockOptions = new Input();
  $loadSignatureBlockOptions->forceLoadFlag = true;
  $loadSignatureBlockOptions->arrOrderByAttributes = array(
    'dsb.`id`' => 'ASC'
  );
 
    $signatureBlockArr = RetentionSignatureBlocks::findByRetentionSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
 
  
  
  $otherCount = 0;
  if($signatureTypeId == 6){
    $otherCount = count($signatureBlockArr);
    if($otherCount == 0){
      $otherCount = 1;
    }
  }
  $updatedDescflag = 'N';
  if(isset($signatureBlockArr) && !empty($signatureBlockArr)) {
    $counti = 0;
    foreach($signatureBlockArr as $signature_block_id => $signatureBolck) {
      if($counti > 0){
        break;
      }
      $signatureBlockId = $signatureBolck->signature_block_id;
      $enable_flag = $signatureBolck->enable_flag;
      $description = $signatureBolck->signature_block_description;
      $updatedDescflag = $signatureBolck->signature_block_desc_update_flag;
      $counti++;
    }
    if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
      $description = $contractingEntityName;
    }
    if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
      $description = $projectOwnerName;
    }
     if($updatedDescflag == 'N' && ($signatureTypeId == 3)){
      $description = $architectName;
    }
    if($enable_flag == 'Y') {
      $enable_flag = 'checked=checked';
    } else {
      $enable_flag = '';
    }
  } else {
    $description = '';
    if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
      $description = $contractingEntityName;
    }
    if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
      $description = $projectOwnerName;
    }
     if($updatedDescflag == 'N' && ($signatureTypeId == 3)){
      $description = $architectName;
    }
    $signatureBlockId = 0;

    $enable_flag = '';
  }


    $jsArray = array(
      'signatureTypeId' => intVal($signatureTypeId),
      'projectId' => intVal($project_id),
      'drawId' => intVal($draw_id),
      'signatureBlockId' => intVal($signatureBlockId)
    );
    $jsOptionJson = json_encode($jsArray);
    $signatureTypeBlockHtmlInput = '';
    $uniqueId = $signatureTypes->signature_type_entity."1";
    $uniqueId =str_replace(' ','_',$uniqueId);
    $signType = str_replace(' ','_',$signatureTypes->signature_type_entity);
    $readOnly = '';
    $readOnlyClass = '';
    $borderRedClass = '';
    $displayNoneClass = 'displayNone';
    if ($enable_flag == ''){
      $readOnly = 'readonly="readonly"';
      $readOnlyClass = 'readOnly';
    } else {
      $displayNoneClass = '';
    }
    if ($enable_flag != '' && ( $description == '' || $description == NULL)){
      $borderRedClass = 'redBorder';
      $displayNoneClass = '';
    }
    // echo "<br>typr def : $signatureTypes->signature_type_default_editable_flag"." == 'Y' && signtype :  $signatureTypeId != 5 && signtype : $signatureTypeId != 2 &&  signtype : $signatureTypeId != 1";
    if($signatureTypes->signature_type_default_editable_flag == 'Y' && $signatureTypeId != 5 && $signatureTypeId != 2 && $signatureTypeId != 1 && $signatureTypeId != 3) {
      if($isDrawDisbaled){
        $descriptionHtml = $description;
      }else{
        $descriptionHtml = <<<DESCRIPTION_HTML
        <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' class="$readOnlyClass $borderRedClass" type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeRetBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
      }
      $signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
      <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
      $descriptionHtml
SIGNATURETYPEBLOCKHTML;
    } else     if($signatureTypes->signature_type_default_editable_flag == 'Y' && ($signatureTypeId == 2 || $signatureTypeId == 1 || $signatureTypeId == 3)) {
        if($isDrawDisbaled){
          $descriptionHtml = '';
        }else{
          $descriptionHtml = <<<DESCRIPTION_HTML
          <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' class="$readOnlyClass $borderRedClass" type="hidden" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeRetBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
        }
        if(!empty($type) && $type == "Retention"){
          $descriptionHtml = <<<DESCRIPTION_HTML
          <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' type="hidden" value="$description" />
DESCRIPTION_HTML;
        }
        $signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
        <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
        $descriptionHtml
        $description
SIGNATURETYPEBLOCKHTML;
    } else {
      if($signatureTypes->signature_type_default_editable_flag == 'Y') {

        if($isDrawDisbaled){
          $descriptionHtml = $description;
        }else{
          $descriptionHtml = <<<DESCRIPTION_HTML
        <input class="$displayNoneClass $uniqueId $readOnlyClass $borderRedClass" id='manage_draw--signature_name--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeRetBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
        }

        $signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
          <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
           $descriptionHtml
SIGNATURETYPEBLOCKHTML;
      }
    }
    $signatureTypeBlockHtmlInputCLTR = '';

    if($signatureTypeId == 5) {
      // get Signature block CL (Construction Lender)
      $loadSignatureBlockCLOptions = new Input();
    $loadSignatureBlockCLOptions->forceLoadFlag = true;
      $arrSBCL = RetentionSignatureBlocksConstructionLender::loadRetentionSignatureBlocksCLBySBId($database, $signatureBlockId, $loadSignatureBlockCLOptions);
      $address1 = '';
      $address2 = '';
      $city_state_zip = '';
      $sb_cl_id = 0;
      $address1RedBorderClass = '';
    $address2RedBorderClass = '';
    $cityRedBorderClass = '';
      if(isset($arrSBCL) && !empty($arrSBCL)) {
          $sb_cl_id = $arrSBCL->signature_block_construction_lender_id;
          $address1 = $arrSBCL->signature_block_construction_lender_address_1;
          $address2 = $arrSBCL->signature_block_construction_lender_address_2;
          $city_state_zip = $arrSBCL->signature_block_construction_lender_city_state_zip;
      }
      if($address1 == '' || $address1 == NULL ){
        $address1RedBorderClass = 'redBorder';
      }
      if($address2 == '' || $address2 == NULL ){
        $address2RedBorderClass = 'redBorder';
      }
      if($city_state_zip == '' || $city_state_zip == NULL ){
        $cityRedBorderClass = 'redBorder';
      }

      if($isDrawDisbaled){
        $address1Html = $address1;
        $address2Html = $address2;
        $cityHtml = $city_state_zip;
      }else{
        $address1Html = <<<ADDRESS_ONE_HTML
        <input class='$address1RedBorderClass' id='manage_draw--signature_address1--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickRetIncludeBlockCL(this, "manage_draw--signature_address1", "$uniqueId", $jsOptionJson)' value="$address1" />
ADDRESS_ONE_HTML;

        $address2Html = <<<ADDRESS_ONE_HTML
        <input class='$address2RedBorderClass' id='manage_draw--signature_address2--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickRetIncludeBlockCL(this, "manage_draw--signature_address2", "$uniqueId", $jsOptionJson)' type="text" value="$address2" />
ADDRESS_ONE_HTML;

        $cityHtml = <<<ADDRESS_ONE_HTML
        <input class='$cityRedBorderClass' id='manage_draw--signature_city--$uniqueId--$signatureTypeId' type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickRetIncludeBlockCL(this, "manage_draw--signature_city", "$uniqueId", $jsOptionJson)' type="text" value="$city_state_zip" />
ADDRESS_ONE_HTML;
      }
      $signatureTypeBlockHtmlInputCLTR = <<<SIGNATURETYPEBLOCKHTML
      <tr class="$displayNoneClass $uniqueId" id='record_container--manage_draw----$signatureTypeId'>
        <td><input type="hidden" id='manage_draw--signature_cl_id--$uniqueId--$signatureTypeId' value="$sb_cl_id"/></td>
        <td>Address 1:</td>
        <td colspan="2">$address1Html</td>
      </tr>
      <tr class="$displayNoneClass $uniqueId" id='record_container--manage_draw----$signatureTypeId'>
        <td></td>
        <td>Address 2:</td>
        <td colspan="2">$address2Html</td>
      </tr>
      <tr class="$displayNoneClass $uniqueId trBorderBottom" id='record_container--manage_draw----$signatureTypeId'>
        <td></td>
        <td>City,State,Zip:</td>
        <td colspan="2">$cityHtml</td>
      </tr>
SIGNATURETYPEBLOCKHTML;
    }
    $trBorderBottomCls = '';
    $trBorderBottomIn ='';
    if($signatureTypeId != 5){
      if($trBorderBottomIn == 0) {
        $trBorderBottomCls = 'trBorderBottom';
      } else {
        $trBorderBottomCls = 'trBorderBottom trBorderTop';
      }
      $trBorderBottomIn = 0;
    } else {
      $trBorderBottomIn = 1;
    }

    $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
    <tr class="$trBorderBottomCls" id='record_container--manage_draw--draw_signature_type--$signatureTypeId'>
SIGNATURETYPEBLOCKHTML;
    if($debugMode){
      $html_signature_type_id =  (!empty($signatureTypeId) ? $signatureTypeId : '&nbsp;');
      $html_signature_block_id =  (!empty($signatureBlockId) ? $signatureBlockId : '&nbsp;');
      $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
      <td class="text-center">$html_signature_type_id</td>
      <td class="text-center">$html_signature_block_id</td>
SIGNATURETYPEBLOCKHTML;
    }
  $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
      <td id='manage_draw--draw_signature_type--include' class="text-center">
      <input type="hidden" id='manage_draw--signature_block_count--$uniqueId--$signatureTypeId' value="$otherCount"/>
      <input type="hidden" id='manage_draw--signature_block_type--$uniqueId--$signatureTypeId' value="$signType"/>
      <input type="hidden" class="otherRet" id='manage_draw--signature_block_id--$uniqueId--$signatureTypeId' onchange='onClickIncludeRetBlock(this, "manage_draw--signature_block_id", "$uniqueId", $jsOptionJson)' value="$signatureBlockId"/>
      <input type="checkbox" $enable_flag $disabled id='manage_draw--signature_include--$uniqueId--$signatureTypeId' onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeRetBlock(this, "manage_draw--signature_include", "$uniqueId", $jsOptionJson)'/></td>
      <td>$signatureTypes->signature_type_entity:</td>
      <td colspn="2">$signatureTypeBlockHtmlInput</td>
    </tr>
    $signatureTypeBlockHtmlInputCLTR
SIGNATURETYPEBLOCKHTML;
      if(!empty($signatureTypeId) && $signatureTypeId == 2 ) {
        $qb_customer_sel = '<tr class="trBorderBottom">';
        if($debugMode){
            $qb_customer_sel .= '<td></td>
                        <td class="text-center">'.$qb_customer_sel_id.'</td>';
        }
        if($isDrawDisbaled){
          $qb_customer_sel .= '
            <td style="vertical-align:top; text-align: center;"><a title="Click to Check Availability & get Project Customer from QB"><img src="/images/refresh_icon.png" style="height:25px; width:25px;" ></a></td>';
        }else{
          $qb_customer_sel .= '
            <td style="vertical-align:top; text-align: center;"><a href="javaScript:void(0);" id="checkindicator" title="Click to Check Availability & get Project Customer from QB"><img src="/images/refresh_icon.png" style="height:25px; width:25px;" ></a></td>';
        }        

        $qb_customer_sel .= '<td class="fields red-text current_indicator"><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB"> Customer:Project </td>
            <td colspan="2" >'.$qb_cust_html.'</td>
          </tr>';
        $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
              $qb_customer_sel
SIGNATURETYPEBLOCKHTML;
       
        
  }
    //  other more than 2
    // get signature block id
  $loadSignatureBlockOptions = new Input();
  $loadSignatureBlockOptions->forceLoadFlag = true;
  $loadSignatureBlockOptions->arrOrderByAttributes = array(
    'dsb.`id`' => 'ASC'
  );
  $signatureBlockArr = RetentionSignatureBlocks::findByRetentionSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
  if(isset($signatureBlockArr) && !empty($signatureBlockArr)) {
    $counti = 0;
    foreach($signatureBlockArr as $signature_block_id => $signatureBolck) {
      if($counti == 0){
        $counti++;
        continue;
      }
      $signatureBlockId = $signatureBolck->signature_block_id;
      $enable_flag = $signatureBolck->enable_flag;
      $description = $signatureBolck->signature_block_description;
      $updatedDescflag = $signatureBolck->signature_block_desc_update_flag;

      if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
        $description = $userCompanyName;
      }
      if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
        $description = $projectOwnerName;
      }
       if($updatedDescflag == 'N' && ($signatureTypeId == 3)){
      $description = $architectName;
    }
      if($enable_flag == 'Y') {
        $enable_flag = 'checked=checked';
      } else {
        $enable_flag = '';
      }
      $jsArray = array(
        'signatureTypeId' => intVal($signatureTypeId),
        'projectId' => intVal($project_id),
        'drawId' => intVal($draw_id),
        'signatureBlockId' => intVal($signatureBlockId)
      );
      $jsOptionJson = json_encode($jsArray);
      $signatureTypeBlockHtmlInput = '';
      $uniqueId = $signatureTypes->signature_type_entity.($counti+1);
      $uniqueId =str_replace(' ','_',$uniqueId);
      $readOnly = '';
      $readOnlyClass = '';
      $borderRedClass = '';
      if ($enable_flag == ''){
        $readOnly = 'readonly="readonly"';
        $readOnlyClass = 'readOnly';
      } else {
        $displayNoneClass = '';
      }
      if ($enable_flag != '' && ( $description == '' || $description == NULL)){
        $borderRedClass = 'redBorder';
        $displayNoneClass = '';
      }
      if($signatureTypes->signature_type_default_editable_flag == 'Y' && $signatureTypeId != 5) {
        if($isDrawDisbaled){
          $descriptionHtml = $description;
        }else{
          $descriptionHtml = <<<DESCRIPTION_HTML
          <input id='manage_draw--signature_name--$uniqueId--$signatureTypeId' class="$readOnlyClass $borderRedClass" type="text" onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeRetBlock(this, "manage_draw--signature_name", "$uniqueId", $jsOptionJson)' value="$description" $readOnly/>
DESCRIPTION_HTML;
        }
        $signatureTypeBlockHtmlInput = <<<SIGNATURETYPEBLOCKHTML
        <input id='manage_draw--signature_desc_udate_flag--$uniqueId--$signatureTypeId'  type="hidden" value="$updatedDescflag"/>
           $descriptionHtml
SIGNATURETYPEBLOCKHTML;
      }
      if($debugMode){
        $html_signature_type_id =  (!empty($signatureTypeId) ? $signatureTypeId : '&nbsp;');
        $html_signature_block_id =  (!empty($signatureBlockId) ? $signatureBlockId : '&nbsp;');
        $signatureTypeBlockDebugHtml = <<<SIGNATURETYPEBLOCKDEBUGHTML
        <td class="text-center">$html_signature_type_id</td>
        <td class="text-center">$html_signature_block_id</td>
SIGNATURETYPEBLOCKDEBUGHTML;
      }else{
        $signatureTypeBlockDebugHtml = '';
      }
      $signatureTypeBlockHtml .= <<<SIGNATURETYPEBLOCKHTML
      <tr id='record_container--removable_draw--$uniqueId--$signatureTypeId'>
      $signatureTypeBlockDebugHtml
      <td id='manage_draw--draw_signature_type--include' class="text-center">
      <input type="hidden" class="otherRet" id='manage_draw--signature_block_id--$uniqueId--$signatureTypeId' onchange='onClickIncludeRetBlock(this, "manage_draw--signature_block_id", "$uniqueId", $jsOptionJson)' value="$signatureBlockId"/>
      <input type="checkbox" $enable_flag $disabled id='manage_draw--signature_include--$uniqueId--$signatureTypeId' onfocusout="checkValueISNull(this, 'manage_draw--signature_include', '$uniqueId', '$signatureTypeId')" onchange='onClickIncludeRetBlock(this, "manage_draw--signature_include", "$uniqueId", $jsOptionJson)'/></td>
      <td>$signatureTypes->signature_type_entity:</td>
      <td>$signatureTypeBlockHtmlInput</td>
      <td><a class="cursorPoint $hideButtonForPosted" onclick="removeRetRowSB(&quot;record_container--removable_draw&quot;,&quot;manage_draw--signature_block_id&quot;, &quot;$uniqueId&quot;,&quot;$signatureTypeId&quot;,$debug_mode_param)"><span class="entypo-cancel-circled"></span></a></td>
      </tr>
SIGNATURETYPEBLOCKHTML;


        }
      $counti++;
    }

  }
  if($debugMode){
    $debugHeadline =
     '<th><span class="textColorWhite">SIGNATURE<br>TYPE<br>ID</span></th>
      <th><span class="textColorWhite">SIGNATURE<br>BLOCK<br>ID</span></th>';
  } else {
    $debugHeadline = '';
  }

  // end more than
  $drawHtmlContent = <<<DrawBlockContent
  <table class="drawSignatureBlockTable">
    <thead>
      <tr class="backgroundColorBlue">
        $debugHeadline
        <th><span class="textColorWhite">Include?</span></th>
        <th class="text-left"><span class="textColorWhite">Entity</span></th>
        <th colspan="2"><span class="textColorWhite">Name</span></th>
      </tr>
    </thead>
    <tbody id="signatureTableContentBody">
      $signatureTypeBlockHtml
    </tbody>
  </table>
  <table style="width:100%;">
    <tbody>
      <tr>
        <td><button type="button" class="btn btn-primary btn-cmn $hideButtonForPosted" onclick="addRetOthersNewRow('manage_draw','$uniqueId', $signatureTypeId, $draw_id, $project_id, $debug_mode_param)">Add</button></td>
        <td></td>
        <td>
          <div class="fields">
            <ul>
              <li class="tasksummary">
              <span class="indicator green-box"></span>
              <b>Exist</b>
              </li>
              <li class="tasksummary">
              <span class="indicator red-box"></span>
              <b>Not Exist</b>
              </li>
            </ul>
          </div>

        </td>
      </tr>
    </tbody>
  </table>
DrawBlockContent;
  return $drawHtmlContent;
}


function updateProjectOwnerContractor($database, $project_id, $draw_id,$type=''){
  $session = Zend_Registry::get('session');
  $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
  $project = Project::findById($database, $project_id);
  
  if( !empty($draw_id) && !empty($project->project_owner_name)){
    if(!empty($type) && $type=='Retention'){
      $drawData = RetentionDraws::findById($database, $draw_id);
    }else{
      $drawData = Draws::findById($database, $draw_id);
    }
    
    
    if(!empty($drawData->status) && $drawData->status == 1){

      $contracting_entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);

      if(!empty($contracting_entity_id)){
        $data = array('contracting_entity_id' => $contracting_entity_id);

        $drawData->getData();
        $drawData->setData($data);
        $drawData->convertDataToProperties();
        $Draw_id = $drawData->save();
      }

      $projectOwnerName = $project->project_owner_name;
      if(!empty($type) && $type == "Retention"){
        $customersignature =  RetentionSignatureBlocks::findByRetentionSignatureBlockById($database, '2', $project_id, $draw_id);
      }else{
        $customersignature = DrawSignatureBlocks::findByDrawSignatureBlockById($database, '2', $project_id, $draw_id); 
      }
      


      if(empty($customersignature) ){
        $data['id'] = Null;
        if(!empty($type) && $type == "Retention"){
           $data['retention_draw_id'] = $draw_id;
        }else
        {
        $data['draw_id'] = $draw_id;
        }
        $data['project_id'] = $project_id;
        $data['signature_type_id'] = '2';
        $data['description'] = $projectOwnerName;
        $data['desc_update_flag'] = 'Y';
        $data['enable_flag'] = 'Y';
        $data['created_by_contact_id'] = $currentlyActiveContactId;
        $data['updated_by_contact_id'] = $currentlyActiveContactId;
        if(!empty($type) && $type == "Retention"){
          $signatureBlockClone = new RetentionSignatureBlocks($database);
        }else{
          $signatureBlockClone = new DrawSignatureBlocks($database);
        }
        
        $signatureBlockClone->setKey(null);
        $signatureBlockClone->getData();
        $signatureBlockClone->setData($data);
        $signatureBlockClone->convertDataToProperties();
        $signatureBlockClone->convertPropertiesToData();
        $signBlock_id = $signatureBlockClone->save();
      }else if(!empty($customersignature) && $customersignature->description != $projectOwnerName){

        $data = array(
                  'description'=>$projectOwnerName,
                  'desc_update_flag'=>'Y',
                  'enable_flag'=>'Y',
                  'updated_by_contact_id'=>$currentlyActiveContactId
                );
        if(!empty($type) && $type == "Retention"){
          $signatureBlockClone = RetentionSignatureBlocks::findById($database, $customersignature->id);
        }else{
          $signatureBlockClone = DrawSignatureBlocks::findById($database, $customersignature->id);
        }
        $signatureBlockClone->getData();
        $signatureBlockClone->setData($data);
        $signatureBlockClone->convertDataToProperties();
        $signBlock_id = $signatureBlockClone->save();
      }
    }
  

  // for Architect name
      if(!empty($drawData->status) && $drawData->status == 1){

         // to get the architect company and architect name
  $Projdetails = Project::findById($database, $project_id);
  $architectCmpyNameRaw = ContactCompany::findByContactUserCompanyId($database, $Projdetails['architect_cmpy_id']);
  $contactName = Contact::findById($database, $Projdetails['architect_cont_id']);
  $architectContNameRaw = ($contactName == '') ? '' : $contactName->getContactFullName();
   $architectName = $architectCmpyNameRaw .":".$architectContNameRaw;

      if(!empty($type) && $type == "Retention"){
        $customerArgsignature =  RetentionSignatureBlocks::findByRetentionSignatureBlockById($database, '3', $project_id, $draw_id);
      }else{
        $customerArgsignature = DrawSignatureBlocks::findByDrawSignatureBlockById($database, '3', $project_id, $draw_id); 
      }
      


      if(empty($customerArgsignature) ){
        $data['id'] = Null;
        if(!empty($type) && $type == "Retention"){
           $data['retention_draw_id'] = $draw_id;
        }else
        {
        $data['draw_id'] = $draw_id;
        }
        $data['project_id'] = $project_id;
        $data['signature_type_id'] = '3';
        $data['description'] = $architectName;
        $data['desc_update_flag'] = 'Y';
        $data['enable_flag'] = 'Y';
        $data['created_by_contact_id'] = $currentlyActiveContactId;
        $data['updated_by_contact_id'] = $currentlyActiveContactId;
        if(!empty($type) && $type == "Retention"){
          $signatureBlockClone = new RetentionSignatureBlocks($database);
        }else{
          $signatureBlockClone = new DrawSignatureBlocks($database);
        }
        
        $signatureBlockClone->setKey(null);
        $signatureBlockClone->getData();
        $signatureBlockClone->setData($data);
        $signatureBlockClone->convertDataToProperties();
        $signatureBlockClone->convertPropertiesToData();
        $signBlock_id = $signatureBlockClone->save();
      }else if(!empty($customerArgsignature) && $customerArgsignature->description != $architectName){

        $data = array(
                  'description'=>$architectName,
                  'desc_update_flag'=>'Y',
                  'enable_flag'=>'Y',
                  'updated_by_contact_id'=>$currentlyActiveContactId
                );
        if(!empty($type) && $type == "Retention"){
          $signatureBlockClone = RetentionSignatureBlocks::findById($database, $customerArgsignature->id);
        }else{
          $signatureBlockClone = DrawSignatureBlocks::findById($database, $customerArgsignature->id);
        }
        $signatureBlockClone->getData();
        $signatureBlockClone->setData($data);
        $signatureBlockClone->convertDataToProperties();
        $signBlock_id = $signatureBlockClone->save();
      }
    }
    //End for Architect name
}
}
