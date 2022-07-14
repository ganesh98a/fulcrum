<?php

	function import_section($database, $user_company_id, $fileUploader,$fileUploaderProgressWindow, $liUploadedPhotos,$userCanExportContacts, $userCanImportContacts){
		$select_drop = contact_companies_sel($database, $user_company_id, 'import_companies', 'import_companies mutipleselect');

		$import_section = '';
		if(!empty($userCanExportContacts) || !empty($userCanImportContacts)){
			$import_section .= '<div style="width: 30%">
								'.$select_drop.'
								</div>';
		}
		$import_section .= '<div class="row">';
		if(!empty($userCanExportContacts)){
			$import_section .= '<div class="col-md-6">
									<div class="panel panel-default" style="height: 250px;">
										<div class="panel-heading">Export</div>
										<div class="panel-body">
											<button class="btn-cmn export_button download_report" style="margin-top: 69px; margin-left: 130px;">Export Contact</button>
										</div>
									</div>
								</div>';
		}

		if(!empty($userCanImportContacts)){
			$import_section .= '<div class="col-md-6">
									<div class="panel panel-default" >
										<div class="panel-heading ">Import</div>
										<div class="panel-body">

											<div style="width: 100;">
												<div class="optionColumn">
													<div class="optionColumnIn">
													    <label>
													    	<input type="radio" name="importOption" value="useDefaultTemplate" checked="" class="radioImport" >Use Default Template
													   	</label>
													    <label>
													    	<input type="radio" name="importOption" value="useMyTemplate" class="radioImport">Use My Template
														</label>
													</div>
												</div>
											</div>
											<div class="default_template">
												<h3>Step - 1: Download the default excel template <span class="fakeHref verticalAlignBottom" onclick="showHideHelp(\'rfi_draft_help3\');" >(?)</span></h3>
												<p>
													<button class="btn-cmn export_button download_template">Download</button>
												</p>
												<h3>Step - 2: Upload File  <span class="fakeHref verticalAlignBottom" onclick="showHideHelp(\'rfi_draft_help\');"  >(?)</span></h3>
												<div class="optionColumn">
													<div class="optionColumnIn">
								                        '.$fileUploader.'
								                        <div id="uploaderJobsitePhotosfileUploaderdiv">
								                        '.$fileUploaderProgressWindow.'
									                        <ul id="record_list_container--manage-file-import-record" class="ulUploadedFiles" style="margin:10px 0 5px 0px;list-style:none;padding:0;">'.$liUploadedPhotos.'
									                        </ul>
								                        </div>
								                        <input type="hidden" id="defaultTemplate" name="defaultTemplate" value="">
		            									<input type="hidden" id="defaultTemplateErrorValid" name="defaultTemplateErrorValid" value="">
		            									<input type="hidden" id="customTemplateErrorValid" name="customTemplateErrorValid" value="">
							                        </div>
							                        <div class="optionColumnIn">
						                        		<input id="importSubmit" type="button" value="Proceed">
						                        	</div>
						                        </div>
					                        </div>
				                        	<div class="custom_template" style="display:none;">
				                        		<h3>Step - 1: Download the excel template <span class="fakeHref verticalAlignBottom" onclick="showHideHelp(\'rfi_draft_help3\');" >(?)</span></h3>
												<p>
													<a href="/xlsx/My Template.xlsx" class="btn-cmn export_button" style="color:white; text-decoration: none;" download>
													Download
													</a>
												</p>
												<h3>Step - 2: Upload File  <span class="fakeHref verticalAlignBottom" onclick="showHideHelp(\'rfi_draft_help2\');"  >(?)</span></h3>
												<div class="UseDefaultTemplate UseMyTemplate" id="UseMyTemplateSH" style="">
							                    	<input type="file" name="excelupload" id="excelupload" >
        										</div> 
    										</div>
										</div>
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div id="defaultTemplateError"></div>
							<div id="customTemplateUpload"></div>
							<div id="Instructions" class="modal"></div>
						';
		}
		return $import_section;
	}

	function contact_companies_sel($database, $user_company_id,$listId = '', $listClass = 'mutipleselect'){
		$arrcompany =  ListofallContactCompanies($database, $user_company_id);
		$listjs="";
		$liststyle="width:250px;";
		$listDefault="Select companies";
		$listselected = "";
		$listMultiple=true;

	 	$res_drop=selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arrcompany,$listselected,$listMultiple);

		 return <<<END_PER_TABLE_TBODY
			$res_drop
END_PER_TABLE_TBODY;

	}

	function ListofallContactCompanies($database, $user_company_id){
		// Load a drop with this user's contact companies
		$arrContactCompaniesByUserUserCompanyId = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);
		$company_arr = array();
		foreach ($arrContactCompaniesByUserUserCompanyId AS $contactCompany) {
		    if ($contactCompany->user_user_company_id == $contactCompany->contact_user_company_id) {
		        $companyName = $contactCompany->contact_company_name . " (My Company)";
		    } else {
		        $companyName = $contactCompany->contact_company_name;
		    }
		    $company_arr[$contactCompany->contact_company_id] = $companyName;
    		
		}
		return $company_arr;
	}

?>