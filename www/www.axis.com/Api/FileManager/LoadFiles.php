<?php

$config = Zend_Registry::get('config');
$fileManagerBasePath = $config->system->file_manager_base_path;
$fileManagerFileNamePrefix = $config->system->file_manager_file_name_prefix;
$basePath = $fileManagerBasePath.'frontend/'.$RN_user_company_id;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['list'] = array();
$currentlySelectedProjectId=$RN_project_id;
$list=array();
$permissions = RN_Permissions::loadPermissions($database, $user, $RN_project_id, true);
/**
 * to get project list 
 */
function getProjectList($database, $RN_userRole, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id){
        $projectList=array();    
        $activeProjectList=array('project_name'=>'Active Projets','project_id'=>'project_1','subProjects'=>array());  
        $biddingProjectList=array('project_name'=>'Bidding Projets','project_id'=>'project_2','subProjects'=>array());  
        $completedProjectList=array('project_name'=>'Completed Projets','project_id'=>'project_3','subProjects'=>array());  
        $otherProjectList=array('project_name'=>'Other Projets','project_id'=>'project_4','subProjects'=>array());  
        $RN_arrOwnedProjects = Project::loadOwnedProjects($database, $RN_userRole, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);
        foreach ($RN_arrOwnedProjects as $RN_arrProjectData) {
            $RN_tmpProjectId = $RN_arrProjectData['id'];
            $RN_project_name = $RN_arrProjectData['project_name'];
            $RN_is_active = $RN_arrProjectData['is_active_flag'];
            $RN_is_internal = $RN_arrProjectData['is_internal_flag'];
            $RN_project_completed_date = $RN_arrProjectData['project_completed_date'];
            $RN_arrProjectsArray[] = $RN_tmpProjectId;
            if ($RN_is_active == 'Y') {
                $subProjects['project_name'] = $RN_project_name;
                $subProjects['project_id'] = $RN_tmpProjectId;
                $RN_projectTypeIndex = 0;
                array_push($activeProjectList['subProjects'],$subProjects);
            } elseif ($RN_is_internal == 'Y') {
                $RN_arrBiddingProjects['project_name'] = $RN_project_name;
                $RN_arrBiddingProjects['project_id'] = $RN_tmpProjectId;
                $RN_projectTypeIndex = 1;
                array_push($biddingProjectList['subProjects'],$RN_arrBiddingProjects);
            } elseif ($RN_project_completed_date != '0000-00-00') {
                $RN_arrCompletedProjects['project_name'] = $RN_project_name;
                $RN_arrCompletedProjects['project_id'] = $RN_tmpProjectId;
                $RN_projectTypeIndex = 2;
                array_push($completedProjectList['subProjects'],$RN_arrCompletedProjects);
            } else {
                $RN_arrOtherProjects['project_name'] = $RN_project_name;
                $RN_arrOtherProjects['project_id'] = $RN_tmpProjectId;
                $RN_projectTypeIndex = 3;
                array_push($otherProjectList['subProjects'],$RN_arrOtherProjects);
            }

        }
        
        // Load "Guest Projects" where the user_id is linked to a contact_id in a third-party contacts list
        $RN_arrGuestProjects = Project::loadGuestProjects($database, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);

        foreach ($RN_arrGuestProjects as $RN_arrProjectData) {
        $RN_tmpProjectId = $RN_arrProjectData['id'];
        $RN_project_name = $RN_arrProjectData['project_name'];
        $RN_is_active = $RN_arrProjectData['is_active_flag'];
        $RN_is_internal = $RN_arrProjectData['is_internal_flag'];
        $RN_project_completed_date = $RN_arrProjectData['project_completed_date'];
        $RN_arrProjectsArray[] = $RN_tmpProjectId;
        if ($RN_debugMode) {
        $RN_project_name = "($RN_tmpProjectId) $RN_project_name";
        }

        if ($RN_is_active == 'Y') {
        $RN_arrActiveProjects['project_name'] = $RN_project_name. " ***";
        $RN_arrActiveProjects['project_id'] = $RN_tmpProjectId;
        $RN_projectTypeIndex = 0;
          array_push($activeProjectList['subProjects'],$RN_arrActiveProjects);
        } elseif ($RN_is_internal == 'Y') {
        $RN_arrBiddingProjects['project_name'] = $RN_project_name. " ***";
        $RN_arrBiddingProjects['project_id'] = $RN_tmpProjectId;
        $RN_projectTypeIndex = 1;
        array_push($biddingProjectList['subProjects'],$RN_arrBiddingProjects);

        } elseif ($RN_project_completed_date != '0000-00-00') {
        $RN_arrCompletedProjects['project_name'] = $RN_project_name. " ***";
        $RN_arrCompletedProjects['project_id'] = $RN_tmpProjectId;
        $RN_projectTypeIndex = 2;
        array_push($completedProjectList['subProjects'],$RN_arrCompletedProjects);

        } else {
        $RN_arrOtherProjects['project_name'] = $RN_project_name. " ***";
        $RN_arrOtherProjects['project_id'] = $RN_tmpProjectId;
        array_push($otherProjectList['subProjects'],$RN_arrOtherProjects);
        $RN_projectTypeIndex = 3;
        }

            if ($RN_tmpProjectId == $RN_currentlySelectedProjectId) {
            $RN_currentlySelectedProjectTypeIndex = $RN_projectTypeIndex;
            $RN_currentlySelectedProjectName = $RN_project_name . " ***";
            }
        }

        // Load "Guest Projects" that the user has been invited to bid through the purchasing module
        $RN_arrGuestProjects = Project::loadGuestProjectsWhereContactHasBeenInvitedToBidThroughThePurchasingModule($database, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);

        foreach ($RN_arrGuestProjects as $RN_arrProjectData) {
            $RN_tmpProjectId = $RN_arrProjectData['id'];
            $RN_project_name = $RN_arrProjectData['project_name'];
            $RN_is_active = $RN_arrProjectData['is_active_flag'];
            $RN_is_internal = $RN_arrProjectData['is_internal_flag'];
            $RN_project_completed_date = $RN_arrProjectData['project_completed_date'];
            $RN_arrProjectsArray[] = $RN_tmpProjectId;
            unset($RN_arrActiveProjects[$RN_tmpProjectId]);
            $RN_arrBiddingProjects['project_name'] = $RN_project_name. " ***";
            $RN_arrBiddingProjects['project_id'] = $RN_tmpProjectId;
            array_push($biddingProjectList['subProjects'],$RN_arrBiddingProjects);

            $RN_projectTypeIndex = 1;
            if ($RN_tmpProjectId == $RN_currentlySelectedProjectId) {
            $RN_currentlySelectedProjectTypeIndex = $RN_projectTypeIndex;
            $RN_currentlySelectedProjectName = $RN_project_name . " ***";
            }
        }
        if($activeProjectList && count($activeProjectList['subProjects'])>0){
            array_push($projectList,$activeProjectList);
        }
        if($completedProjectList && count($completedProjectList['subProjects'])>0){
            array_push($projectList,$completedProjectList);
        } if($biddingProjectList && count($biddingProjectList['subProjects'])>0){
            array_push($projectList,$biddingProjectList);
        } if($otherProjectList && count($otherProjectList['subProjects'])>0){
            array_push($projectList,$otherProjectList);
        }
        return $projectList;
}
function getTrashFolders($database, $file_manager_folder_id, $trashCan, $loadTrashFlag, $permissions, $RN_user_company_id, $currentlySelectedProjectUserCompanyId, $RN_project_id, $user, $isCount=false){
        $list=array();
        $AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		// Trash Can/Recycle Bin
		// Load trash can contents for "Company" Folders and Files
		$arrTrashCompanyFileManagerFolders = FileManagerFolder::loadTrashByProjectId($database, $RN_user_company_id, $AXIS_NON_EXISTENT_PROJECT_ID);
		$arrTrashCompanyFileManagerFiles = FileManagerFile::loadTrashByProjectId($database, $RN_user_company_id, $AXIS_NON_EXISTENT_PROJECT_ID);

		// Use the active project_id from the session (check to see if "1")
		// Find "Currently Selected Project" Folders and Files in the trash.
		if ($RN_project_id != $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Load trash can contents for "Currently Selected Project" Folders and Files
			$arrTrashCurrentlySelectedProjectFileManagerFolders = FileManagerFolder::loadTrashByProjectId($database, $currentlySelectedProjectUserCompanyId, $RN_project_id);
			$arrTrashCurrentlySelectedProjectFileManagerFiles = FileManagerFile::loadTrashByProjectId($database, $currentlySelectedProjectUserCompanyId, $RN_project_id);
      
        } else {
			$arrTrashCurrentlySelectedProjectFileManagerFolders = array();
			$arrTrashCurrentlySelectedProjectFileManagerFiles = array();
		}

		$arrTrashFolders = $arrTrashCompanyFileManagerFolders + $arrTrashCurrentlySelectedProjectFileManagerFolders;
		$arrTrashFiles = $arrTrashCompanyFileManagerFiles + $arrTrashCurrentlySelectedProjectFileManagerFiles;
        
        if (!empty($arrTrashFolders) || !empty($arrTrashFiles)) {
			
			// Iterate over virtual folders list
			foreach ($arrTrashFolders as $fileManagerFolder) {
				/* @var $fileManagerFolder FileManagerFolder */
				$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
				$virtualFilePath = $fileManagerFolder->virtual_file_path;
				$arrFolders = preg_split('#/#', $virtualFilePath, -1, PREG_SPLIT_NO_EMPTY);
				$activeVirtualFolder = array_pop($arrFolders);
				$escapedVirtualFilePath = htmlentities($virtualFilePath, ENT_QUOTES, "UTF-8");
				$escapedActiveVirtualFolder = htmlentities($activeVirtualFolder, ENT_QUOTES, "UTF-8");
				$id = $file_manager_folder_id;
              
				$permissionClassList = '';
				/**/
				$arrFolderPermissionsMatrix = FileManagerFolder::loadPermissionsMatrixByIdList($database, array($file_manager_folder_id), $RN_project_id,$permissions);
                if (
					isset($arrFolderPermissionsMatrix) && !empty($arrFolderPermissionsMatrix) &&
					isset($arrFolderPermissionsMatrix[$file_manager_folder_id]) && !empty($arrFolderPermissionsMatrix[$file_manager_folder_id])
				) {
					$rename_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_id]['rename_privilege'];
					$upload_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_id]['upload_privilege'];
					$move_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_id]['move_privilege'];
					$delete_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_id]['delete_privilege'];
					$arrPermissionClasses = array();
					
					if ($delete_privilege == 'Y') {
						$arrPermissionClasses[] = 'delete';
					}
					$permissionClassList = join(' ',$arrPermissionClasses);
				}
				/**/
				if ($permissionClassList != '') {
                    $trashFolder=array();
                    $trashFolder['name']=$escapedActiveVirtualFolder;
                    $trashFolder['folder_id']=$id;
                    $trashFolder['isFolder']=true;
                    $trashFolder['isFile']=false;
                    array_push($list,$trashFolder);
                }
				
			}

			//$virtualFileBasePath = $parentFileManagerFolder->virtual_file_path;
			$virtualFileBasePath = '/Trash/';
			$escapedVirtualFileBasePath = htmlentities($virtualFileBasePath, ENT_QUOTES, "UTF-8");

			// Iterate over virtual files list
			foreach ($arrTrashFiles as $fileManagerFile) {
				/* @var $fileManagerFile FileManagerFile */
				$file_manager_file_id = $fileManagerFile->file_manager_file_id;
				$virtualFileName = $fileManagerFile->virtual_file_name;
				$escapedVirtualFileName = htmlentities($virtualFileName, ENT_QUOTES, "UTF-8");
				$escapedFullVirtualFilePath = $escapedVirtualFileBasePath.$escapedVirtualFileName;
				$ext = preg_replace('/^.*\./', '', $virtualFileName);
				$id = $file_manager_file_id;

				$permissionClassList = '';

				$arrFilePermissionsMatrix = FileManagerFile::loadPermissionsMatrixByIdList($database, array($file_manager_file_id), $RN_project_id,$permissions);
				if (
					isset($arrFilePermissionsMatrix) && !empty($arrFilePermissionsMatrix) &&
					isset($arrFilePermissionsMatrix[$file_manager_file_id]) && !empty($arrFilePermissionsMatrix[$file_manager_file_id])
				) {
					$rename_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['rename_privilege'];
					$move_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['move_privilege'];
					$delete_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['delete_privilege'];
					$arrPermissionClasses = array();
					
					if ($delete_privilege == 'Y') {
						$arrPermissionClasses[] = 'delete';
					}
					$permissionClassList = join(' ',$arrPermissionClasses);
				}

                //to get file url 
                $RN_rfiPdfUrl = null;
                $accessFiles=false;
                if($fileManagerFile->file_manager_file_id != null){
                    $fileManagerFile = FileManagerFile::findById($database, $fileManagerFile->file_manager_file_id);
                    if(isset($fileManagerFile) && !empty($fileManagerFile)){
                        $RN_rfiPdfUrl = $fileManagerFile->generateUrl(true);

                        $RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

                        $RN_explodeValue = explode('?', $RN_rfiPdfUrl);
                        if(isset($RN_explodeValue[1])){
                            $RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
                        }
                        $RN_rfiPdfUrl = $RN_rfiPdfUrl.$RN_id;
                        $RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $fileManagerFile->file_manager_file_id);
                        $accessFiles = false;
                        if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
                            if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
                                $accessFiles = false;
                            } else {
                                $accessFiles = true;
                            }
                        }
                    }
                }
                /**
                 * to create thumbanil for pdf files
                 */
                $thumbnailImage=null;
                if($ext==='pdf' && !$isCount){
                    $thumbnailImage=createThumbnail($escapedVirtualFileName,$fileManagerFile);
                }
				if ($permissionClassList != '') {
                    $trashFolder=array();
                    $trashFolder['name']=$escapedVirtualFileName;
                    $trashFolder['folder_id']=$id;
                    $trashFolder['isFolder']=false;
                    $trashFolder['ext']=$ext;
                    $trashFolder['isFile']=true;
                    $trashFolder['thumbnailImage']=$thumbnailImage;
                    $trashFolder['filePath']=$RN_rfiPdfUrl;
                    $trashFolder['fileAccess']=$accessFiles;
                    array_push($list,$trashFolder);
				}
			}
        }
        return $list;
}
/**
 * to get folders by node id 
 */
function getFilesByNodeId($file_manager_folder_id,$trashCan,$loadTrashFlag,$permissions,$user,$RN_userRole,$database, $RN_project_id, $isTrashFolder = false,$isCount=false){

    $list=array();

        $userCanReportDelays =  $permissions->determineAccessToSoftwareModuleFunction('delay_logs_view');
       
        $userCanReportTransmittal = $permissions->determineAccessToSoftwareModuleFunction('view_transmittal');
        $userCanDaliylog = $permissions->determineAccessToSoftwareModuleFunction('jobsite_daily_logs_view');
        $userCansubmittal = $permissions->determineAccessToSoftwareModuleFunction('submittals_view');
        $userCanchangeordersreport = $permissions->determineAccessToSoftwareModuleFunction('change_orders_view');
        $userCanViewRFIs = $permissions->determineAccessToSoftwareModuleFunction('rfis_view');
        //For Global Admin All will be available for Global admin
        if($RN_userRole =="global_admin")
        {
            $userCanReportDelays = $userCanReportTransmittal = $userCanDaliylog = $userCansubmittal = $userCanchangeordersreport = $userCanViewRFIs ='1';
         }
    $loadTrashFlag = false;
    $parentFileManagerFolder = FileManagerFolder::findById($database, $file_manager_folder_id);
    if ($parentFileManagerFolder) { 
        $virtualFilePathExistsFlag = true;
    } else {
        $virtualFilePathExistsFlag = false;
    }

    if ($virtualFilePathExistsFlag) {
    $file_manager_folder_id = $parentFileManagerFolder->file_manager_folder_id;

    $virtual_file_path = $parentFileManagerFolder->virtual_file_path;
    $project_id = $parentFileManagerFolder->project_id;
    $AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
    if ($parentFileManagerFolder->project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
        $arrCompanyFileManagerFolders =
            FileManagerFolder::loadAccessibleChildFoldersByVirtualFilePath($database, $permissions, $parentFileManagerFolder, false);
        $arrCompanyFileManagerFiles =
            FileManagerFile::loadAccessibleChildFilesByVirtualFolderId($database, $permissions, $parentFileManagerFolder, false);
    } else {
        $arrCompanyFileManagerFolders = array();
        $arrCompanyFileManagerFiles = array();
    }
 
     
    if ($parentFileManagerFolder->project_id != $AXIS_NON_EXISTENT_PROJECT_ID) {
        $arrCurrentlySelectedProjectFileManagerFolders =
            FileManagerFolder::loadAccessibleChildFoldersByVirtualFilePath($database, $permissions, $parentFileManagerFolder, $isTrashFolder);
        $arrCurrentlySelectedProjectFileManagerFiles =
            FileManagerFile::loadAccessibleChildFilesByVirtualFolderId($database, $permissions, $parentFileManagerFolder, $isTrashFolder);
    } else {
        $arrCurrentlySelectedProjectFileManagerFolders = array();
        $arrCurrentlySelectedProjectFileManagerFiles = array();
    }
  
    if (!empty($arrCompanyFileManagerFolders) || !empty($arrCompanyFileManagerFiles)) {
        // Iterate over virtual folders list
        foreach ($arrCompanyFileManagerFolders as $file_manager_folder_child_id => $fileManagerFolder) {
            /* @var $fileManagerFolder FileManagerFolder */
            $virtualFilePath = $fileManagerFolder->virtual_file_path;
            $arrFolders = preg_split('#/#', $virtualFilePath, -1, PREG_SPLIT_NO_EMPTY);
            $activeVirtualFolder = array_pop($arrFolders);
            $escapedVirtualFilePath = htmlentities($virtualFilePath, ENT_QUOTES, "UTF-8");
            $escapedActiveVirtualFolder = htmlentities($activeVirtualFolder, ENT_QUOTES, "UTF-8");
            $id = $file_manager_folder_child_id;
            
 
            $permissionClassList = '';
            /**/
            $arrFolderPermissionsMatrix = FileManagerFolder::loadPermissionsMatrixByIdList($database, array($file_manager_folder_id), $RN_project_id, $permissions);
            
            if (
                isset($arrFolderPermissionsMatrix) && !empty($arrFolderPermissionsMatrix) &&
                isset($arrFolderPermissionsMatrix[$file_manager_folder_child_id]) && !empty($arrFolderPermissionsMatrix[$file_manager_folder_child_id])
            ) {
                $rename_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['rename_privilege'];
                $upload_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['upload_privilege'];
                $move_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['move_privilege'];
                $delete_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['delete_privilege'];
                $arrPermissionClasses = array();
                if ($rename_privilege == 'Y') {
                    $arrPermissionClasses[] = 'rename';
                }
                if ($upload_privilege == 'Y') {
                    $arrPermissionClasses[] = 'upload';
                }
                if ($move_privilege == 'Y') {
                    $arrPermissionClasses[] = 'move';
                }
                if ($delete_privilege == 'Y') {
                    $arrPermissionClasses[] = 'delete';
                }
                $permissionClassList = join(' ',$arrPermissionClasses);
            }
            $formattedName = htmlspecialchars_decode($escapedActiveVirtualFolder);
            $formattedName= html_entity_decode($escapedActiveVirtualFolder, ENT_QUOTES, "UTF-8");
            $manageFolder=array();
            $manageFolder['name']=$formattedName;
            $manageFolder['id']=null;
            $manageFolder['folder_id']=$id;
            $manageFolder['isFolder']=true;
            $manageFolder['isFile']=false;
            $manageFolder['permissionClassList']=$permissionClassList;
            array_push($list,$manageFolder);
                }
         
        $virtualFileBasePath = $parentFileManagerFolder->virtual_file_path;
        $escapedVirtualFileBasePath = htmlentities($virtualFileBasePath, ENT_QUOTES, "UTF-8");

        // Iterate over virtual files list
        foreach ($arrCompanyFileManagerFiles as $fileManagerFile) {
            /* @var $fileManagerFile FileManagerFile */
            $file_manager_file_id = $fileManagerFile->file_manager_file_id;
            $virtualFileName = $fileManagerFile->virtual_file_name;
            $escapedVirtualFileName = htmlentities($virtualFileName, ENT_QUOTES, "UTF-8");
            $virtualFileNameWithoutExtention = $fileManagerFile->getFileNameWithoutExtension();
            $escapedVirtualFileNameWithoutExtention = htmlentities($virtualFileNameWithoutExtention, ENT_QUOTES, "UTF-8");
            $escapedFullVirtualFilePath = $escapedVirtualFileBasePath.$escapedVirtualFileName;
            $ext = preg_replace('/^.*\./', '', $virtualFileName);
            $id = $file_manager_file_id;
            $permissionClassList = '';
            $arrFilePermissionsMatrix=array();
            /**/
            $arrFilePermissionsMatrix = FileManagerFile::loadPermissionsMatrixByIdList($database, array($file_manager_file_id), $RN_project_id, $permissions);
            if (
                isset($arrFilePermissionsMatrix) && !empty($arrFilePermissionsMatrix) &&
                isset($arrFilePermissionsMatrix[$file_manager_file_id]) && !empty($arrFilePermissionsMatrix[$file_manager_file_id])
            ) {
                $rename_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['rename_privilege'];
                $move_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['move_privilege'];
                $delete_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['delete_privilege'];
                $arrPermissionClasses = array();
                if ($rename_privilege == 'Y') {
                    $arrPermissionClasses[] = 'rename';
                }
                if ($move_privilege == 'Y') {
                    $arrPermissionClasses[] = 'move';
                }
                if ($delete_privilege == 'Y') {
                    $arrPermissionClasses[] = 'delete';
                }
                $permissionClassList = join(' ',$arrPermissionClasses);
            }
            /**/
            $manageFolder=array();
            $formattedName = htmlspecialchars_decode($escapedVirtualFileName);
            $formattedName= html_entity_decode($escapedVirtualFileName, ENT_QUOTES, "UTF-8");
              //to get file url 
                $RN_rfiPdfUrl = null;
                  $accessFiles = false;
                if($fileManagerFile->file_manager_file_id != null){
                    $fileManagerFile = FileManagerFile::findById($database, $fileManagerFile->file_manager_file_id);
                    if(isset($fileManagerFile) && !empty($fileManagerFile)){
                        $RN_rfiPdfUrl = $fileManagerFile->generateUrl(true);

                        $RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

                        $RN_explodeValue = explode('?', $RN_rfiPdfUrl);
                        if(isset($RN_explodeValue[1])){
                            $RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
                        }
                        $RN_rfiPdfUrl = $RN_rfiPdfUrl.$RN_id;
                        $RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $fileManagerFile->file_manager_file_id);
                        $accessFiles = false;
                        if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
                            if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
                                $accessFiles = false;
                            } else {
                                $accessFiles = true;
                            }
                        }
                    }
                }
            $thumbnailImage=null;
            if($ext==='pdf' && !$isCount){
                $thumbnailImage=createThumbnail($formattedName,$fileManagerFile);
            }
            $manageFolder['name']=$formattedName;
            $manageFolder['id']=null;
            $manageFolder['folder_id']=$id;
            $manageFolder['isFile']=true;
            $manageFolder['filePath']=$RN_rfiPdfUrl;
            $manageFolder['isFolder']=false;
            $manageFolder['ext']=$ext;
            $manageFolder['thumbnailImage']=$thumbnailImage;
            $manageFolder['fileAccess']=$accessFiles;
            $manageFolder['permissionClassList']=$permissionClassList;
            array_push($list,$manageFolder);
            
        }
    }
// echo "<pre>";
// print_r($arrCurrentlySelectedProjectFileManagerFolders);
    if (!empty($arrCurrentlySelectedProjectFileManagerFolders) || !empty($arrCurrentlySelectedProjectFileManagerFiles)) {

    // Iterate over virtual folders list
    foreach ($arrCurrentlySelectedProjectFileManagerFolders as $file_manager_folder_child_id => $fileManagerFolder) {
            /* @var $fileManagerFolder FileManagerFolder */
            $virtualFilePath = $fileManagerFolder->virtual_file_path;
            $arrFolders = preg_split('#/#', $virtualFilePath, -1, PREG_SPLIT_NO_EMPTY);
            $activeVirtualFolder = array_pop($arrFolders);
            $escapedVirtualFilePath = htmlentities($virtualFilePath, ENT_QUOTES, "UTF-8");
            $escapedActiveVirtualFolder = htmlentities($activeVirtualFolder, ENT_QUOTES, "UTF-8");
            $id = $file_manager_folder_child_id;
            
 
            $permissionClassList = '';
            /**/
            $arrFolderPermissionsMatrix = FileManagerFolder::loadPermissionsMatrixByIdList($database, array($file_manager_folder_id), $RN_project_id, $permissions);
            
            if (
                isset($arrFolderPermissionsMatrix) && !empty($arrFolderPermissionsMatrix) &&
                isset($arrFolderPermissionsMatrix[$file_manager_folder_child_id]) && !empty($arrFolderPermissionsMatrix[$file_manager_folder_child_id])
            ) {
                $rename_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['rename_privilege'];
                $upload_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['upload_privilege'];
                $move_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['move_privilege'];
                $delete_privilege = $arrFolderPermissionsMatrix[$file_manager_folder_child_id]['delete_privilege'];
                $arrPermissionClasses = array();
                if ($rename_privilege == 'Y') {
                    $arrPermissionClasses[] = 'rename';
                }
                if ($upload_privilege == 'Y') {
                    $arrPermissionClasses[] = 'upload';
                }
                if ($move_privilege == 'Y') {
                    $arrPermissionClasses[] = 'move';
                }
                if ($delete_privilege == 'Y') {
                    $arrPermissionClasses[] = 'delete';
                }
                $permissionClassList = join(' ',$arrPermissionClasses);
            }
            $formattedName = htmlspecialchars_decode($escapedActiveVirtualFolder);
            $formattedName= html_entity_decode($escapedActiveVirtualFolder, ENT_QUOTES, "UTF-8");
            $manageFolder=array();
            $manageFolder['name']=$formattedName;
            $manageFolder['id']=null;
            $manageFolder['folder_id']=$id;
            $manageFolder['isFolder']=true;
            $manageFolder['isFile']=false;
            $manageFolder['permissionClassList']=$permissionClassList;
            array_push($list,$manageFolder);
                
        }

    $virtualFileBasePath = $parentFileManagerFolder->virtual_file_path;
    $escapedVirtualFileBasePath = htmlentities($virtualFileBasePath, ENT_QUOTES, "UTF-8");

    // Iterate over virtual files list
        foreach ($arrCurrentlySelectedProjectFileManagerFiles as $fileManagerFile) {
            /* @var $fileManagerFile FileManagerFile */
            $file_manager_file_id = $fileManagerFile->file_manager_file_id;
            $fileManagerFile->loadPermissions($permissions);
            $virtualFileName = $fileManagerFile->virtual_file_name;
            $escapedVirtualFileName = htmlentities($virtualFileName, ENT_QUOTES, "UTF-8");
            $virtualFileNameWithoutExtention = $fileManagerFile->getFileNameWithoutExtension();
            $escapedVirtualFileNameWithoutExtention = htmlentities($virtualFileNameWithoutExtention, ENT_QUOTES, "UTF-8");
            $escapedFullVirtualFilePath = $escapedVirtualFileBasePath.$escapedVirtualFileName;
            $ext = preg_replace('/^.*\./', '', $virtualFileName);
            $id = $file_manager_file_id;
            

            $permissionClassList = '';

            $arrFilePermissionsMatrix = FileManagerFile::loadPermissionsMatrixByIdList($database, array($file_manager_file_id), $RN_project_id, $permissions);
            if (
                isset($arrFilePermissionsMatrix) && !empty($arrFilePermissionsMatrix) &&
                isset($arrFilePermissionsMatrix[$file_manager_file_id]) && !empty($arrFilePermissionsMatrix[$file_manager_file_id])
            ) {
                $rename_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['rename_privilege'];
                $move_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['move_privilege'];
                $delete_privilege = $arrFilePermissionsMatrix[$file_manager_file_id]['delete_privilege'];
                $arrPermissionClasses = array();
                if ($rename_privilege == 'Y') {
                    $arrPermissionClasses[] = 'rename';
                }
                if ($move_privilege == 'Y') {
                    $arrPermissionClasses[] = 'move';
                }
                if ($delete_privilege == 'Y') {
                    $arrPermissionClasses[] = 'delete';
                }
                $permissionClassList = join(' ',$arrPermissionClasses);
            }
             $formattedName = htmlspecialchars_decode($escapedVirtualFileName);
            $formattedName= html_entity_decode($escapedVirtualFileName, ENT_QUOTES, "UTF-8");
              //to get file url 
                $RN_rfiPdfUrl = null;
                $accessFiles = false;
                if($fileManagerFile->file_manager_file_id != null){
                    $fileManagerFile = FileManagerFile::findById($database, $fileManagerFile->file_manager_file_id);
                    if(isset($fileManagerFile) && !empty($fileManagerFile)){
                        $RN_rfiPdfUrl = $fileManagerFile->generateUrl(true);

                        $RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

                        $RN_explodeValue = explode('?', $RN_rfiPdfUrl);
                        if(isset($RN_explodeValue[1])){
                            $RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
                        }
                        $RN_rfiPdfUrl = $RN_rfiPdfUrl.$RN_id;
                          $RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $fileManagerFile->file_manager_file_id);
                        $accessFiles = false;
                        if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
                            if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
                                $accessFiles = false;
                            } else {
                                $accessFiles = true;
                            }
                        }
                    }
                }
                $thumbnailImage=null;

                if($ext==='pdf' && !$isCount){
                    $thumbnailImage=createThumbnail($formattedName,$fileManagerFile);
                }
                $manageFolder=array();
                $manageFolder['name']=$formattedName;
                $manageFolder['id']=null;
                $manageFolder['folder_id']=$id;
                $manageFolder['isFile']=true;
                $manageFolder['isFolder']=false;
                $manageFolder['ext']=$ext;
                $manageFolder['filePath']=$RN_rfiPdfUrl;
                $manageFolder['fileAccess']=$accessFiles;
                $manageFolder['permissionClassList']=$permissionClassList;
                $manageFolder['thumbnailImage']=$thumbnailImage;
                array_push($list,$manageFolder);
        }
    }
    }
 
    return $list;
}
/***
 * To create  thumbnail from pdf
 */
function createThumbnail($escapedVirtualFileName,$fileManagerFile){
    $config = Zend_Registry::get('config');
    // file manager backend storage path
    $file_manager_base_path = $config->system->file_manager_base_path;
    $file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
    $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
    $fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
    $arrFilePath = FileManager::createFilePathFromId($fileManagerFile->file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
    $arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
    $path = $arrPath;
    // ghost script path
    $gsPath = $config->ghostscript->gs_path;
    if(is_file($path)){
        $outputPath=$path.'_thumbnail';
        // $operatingSystem = Application::getOperatingSystem();
        // if ($operatingSystem == 'Windows') {
        //     $gsPath='C:\bin\gs9.27\bin\gswin64';
        // }else{
        //     $gsPath='/usr/bin/gs';
        // }
        //
        $cmd =  "${gsPath} -dSAFER -dBATCH -dNOPAUSE -sDEVICE=png16m -r150  -dTextAlphaBits=4 -sOutputFile=${outputPath} -dFirstPage=1 -dLastPage=1 ${path}";
        $output = array();
        $output=shell_exec($cmd);
        $outputPath = $fileManagerFile->generateUrl(true);
        $RN_id = 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
        $RN_explodeValue = explode('?', $outputPath);
        if(isset($RN_explodeValue[1])){
            $outputPath .= "&thumbnail=1&$RN_id";
        } else {
            $outputPath .= "?thumbnail=1&$RN_id";
        }        
        return $outputPath;
    }

}

try {
        $projectFolderExist = false;
        if($RN_Dir){
            $ajaxInput = $RN_Dir;
            $isTrashFolder=$isTrash;
            $trashCan = false;
            $loadTrashFlag = false;
            if (isset($ajaxInput) && $ajaxInput == -1) {
                $trashCan = true;
                $loadTrashFlag = true;
                $file_manager_folder_id = null;
            } elseif (isset($ajaxInput) && !empty($ajaxInput)) {
                $file_manager_folder_id = Data::parseInt($ajaxInput);
            } else {
                $file_manager_folder_id = null;
            }

            if (isset($file_manager_folder_id) && !empty($file_manager_folder_id) && !$trashCan) {

               $list=getFilesByNodeId($file_manager_folder_id,$trashCan,$loadTrashFlag,$permissions,$user,$RN_userRole,$database, $RN_project_id);
            }else{
                $list=getTrashFolders($database, $file_manager_folder_id,$trashCan,$loadTrashFlag,$permissions,$RN_user_company_id,$currentlySelectedProjectUserCompanyId,$RN_project_id,$user,$RN_userRole);
            }
        }else{
            //check company folder exist
            $rootCompanyFileManagerFolder = new FileManagerFolder($database);
            $key = array(
                'user_company_id' => $RN_user_company_id,
                'project_id' => $AXIS_NON_EXISTENT_PROJECT_ID,
                'virtual_file_path' => '/'
            );
            $rootCompanyFileManagerFolder->setKey($key);
            $rootCompanyFileManagerFolder->load();
            $companyFoldersExistFlag = $rootCompanyFileManagerFolder->isDataLoaded();
            if ($companyFoldersExistFlag) {
                $rootCompanyFileManagerFolder->convertDataToProperties();
                $rootCompany_file_manager_folder_id = $rootCompanyFileManagerFolder->file_manager_folder_id;
            } else {
                $rootCompanyFileManagerFolder->setKey(null);
                $data = $key;
                $data['contact_id'] =$RN_currentlyActiveContactId;
                $data['modified'] = null;
                $data['created'] = null;
                $rootCompanyFileManagerFolder->setData($data);
                $rootCompany_file_manager_folder_id = $rootCompanyFileManagerFolder->save();
                $rootCompanyFileManagerFolder->setKey($key);
                $rootCompanyFileManagerFolder->setData(null);
                $rootCompanyFileManagerFolder->load();
                $rootCompanyFileManagerFolder->convertDataToProperties();
                $rootCompany_file_manager_folder_id = $rootCompanyFileManagerFolder->file_manager_folder_id;
                $companyFoldersExistFlag = $rootCompanyFileManagerFolder->isDataLoaded();
            }
        //check project folder exist
            if ($currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID) {
                    $rootCurrentlySelectedProjectFileManagerFolder = new FileManagerFolder($database);
                    $key = array(
                        'user_company_id' => $RN_user_company_id,
                        'project_id' => $currentlySelectedProjectId,
                        'virtual_file_path' => '/'
                    );
                    $rootCurrentlySelectedProjectFileManagerFolder->setKey($key);
                    $rootCurrentlySelectedProjectFileManagerFolder->load();
                    $currentlySelectedProjectFoldersExistFlag = $rootCurrentlySelectedProjectFileManagerFolder->isDataLoaded();
            } else {
                $currentlySelectedProjectFoldersExistFlag = false;
            }
            if ($currentlySelectedProjectFoldersExistFlag) {
                $rootCurrentlySelectedProjectFileManagerFolder->convertDataToProperties();
                $rootCurrentlySelectedProject_file_manager_folder_id = $rootCurrentlySelectedProjectFileManagerFolder->file_manager_folder_id;
            } elseif ($currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID) {
                $rootCurrentlySelectedProjectFileManagerFolder = new FileManagerFolder($database);
                $key = array(
                    'user_company_id' => $currentlySelectedProjectUserCompanyId,
                    'project_id' => $RN_project_id,
                    'virtual_file_path' => '/'
                );
                $rootCurrentlySelectedProjectFileManagerFolder->setKey(null);
                $data = $key;
                $data['contact_id'] = $RN_currentlyActiveContactId;
                $data['modified'] = null;
                $data['created'] = null;
                $rootCurrentlySelectedProjectFileManagerFolder->setData($data);
                $rootCurrentlySelectedProject_file_manager_folder_id = $rootCurrentlySelectedProjectFileManagerFolder->save();
                $rootCurrentlySelectedProjectFileManagerFolder->setKey($key);
                $rootCurrentlySelectedProjectFileManagerFolder->setData(null);
                $rootCurrentlySelectedProjectFileManagerFolder->load();
                $rootCurrentlySelectedProjectFileManagerFolder->convertDataToProperties();
                $rootCurrentlySelectedProject_file_manager_folder_id = $rootCurrentlySelectedProjectFileManagerFolder->file_manager_folder_id;
                $currentlySelectedProjectFoldersExistFlag = $rootCurrentlySelectedProjectFileManagerFolder->isDataLoaded();
            }
            // check  project  owned by other  folder exist
            // "Currently Selected Project Folders & Files" case and user's user_company does NOT own the project
            if ($currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID && $RN_user_company_id != $currentlySelectedProjectUserCompanyId) {
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder = new FileManagerFolder($database);
                $key = array(
                        'user_company_id' => $RN_user_company_id,
                        'project_id' => $RN_project_id,
                        'virtual_file_path' => '/'
                );
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->setKey($key);
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->load();
                $currentlySelectedProjectOwnedByOtherFoldersExistFlag = $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->isDataLoaded();
            } else {
                $currentlySelectedProjectOwnedByOtherFoldersExistFlag = false;
            }
            if ($currentlySelectedProjectOwnedByOtherFoldersExistFlag) {
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->convertDataToProperties();
                $rootCurrentlySelectedProjectOwnedByOther_file_manager_folder_id = $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->file_manager_folder_id;
            } elseif ($currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID && $RN_user_company_id != $currentlySelectedProjectUserCompanyId) {
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder = new FileManagerFolder($database);
                $key = array(
                    'user_company_id' => $RN_user_company_id,
                    'project_id' => $RN_project_id,
                    'virtual_file_path' => '/'
                );
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->setKey(null);
                $data = $key;
                $data['contact_id'] = $RN_currentlyActiveContactId;
                $data['modified'] = null;
                $data['created'] = null;
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->setData($data);
                $rootCurrentlySelectedProjectOwnedByOther_file_manager_folder_id = $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->save();

                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->setKey($key);
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->setData(null);
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->load();
                $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->convertDataToProperties();
                $rootCurrentlySelectedProjectOwnedByOther_file_manager_folder_id = $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->file_manager_folder_id;
                $currentlySelectedProjectOwnedByOtherFoldersExistFlag = $rootCurrentlySelectedProjectOwnedByOtherFileManagerFolder->isDataLoaded();
            }
            //check trash has folders
            $arrTrashCompanyFileManagerFolders = FileManagerFolder::loadTrashByProjectId($database, $RN_user_company_id, 1);
            $arrTrashCompanyFileManagerFiles = FileManagerFile::loadTrashByProjectId($database, $RN_user_company_id, 1);
            if ($currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID) {
                $arrTrashCurrentlySelectedProjectFileManagerFolders = FileManagerFolder::loadTrashByProjectId($database, $currentlySelectedProjectUserCompanyId, $RN_project_id);
                $arrTrashCurrentlySelectedProjectFileManagerFiles = FileManagerFile::loadTrashByProjectId($database, $currentlySelectedProjectUserCompanyId, $RN_project_id);
            } else {
                $arrTrashCurrentlySelectedProjectFileManagerFolders = array();
                $arrTrashCurrentlySelectedProjectFileManagerFiles = array();
            }
            $arrTrashFolders = $arrTrashCompanyFileManagerFolders + $arrTrashCurrentlySelectedProjectFileManagerFolders;
            $arrTrashFiles = $arrTrashCompanyFileManagerFiles + $arrTrashCurrentlySelectedProjectFileManagerFiles;
            $permissionClassList = array();
            if ($companyFoldersExistFlag) {
                $id = $rootCompany_file_manager_folder_id;
                $arrFolderPermissionsMatrix = FileManagerFolder::loadPermissionsMatrixByIdList($database, array($id), $AXIS_NON_EXISTENT_PROJECT_ID, $permissions);
                if (
					isset($arrFolderPermissionsMatrix) && !empty($arrFolderPermissionsMatrix) &&
					isset($arrFolderPermissionsMatrix[$id]) && !empty($arrFolderPermissionsMatrix[$id])
				) {
					$rename_privilege = $arrFolderPermissionsMatrix[$id]['rename_privilege'];
					$upload_privilege = $arrFolderPermissionsMatrix[$id]['upload_privilege'];
					$move_privilege = $arrFolderPermissionsMatrix[$id]['move_privilege'];
					$delete_privilege = $arrFolderPermissionsMatrix[$id]['delete_privilege'];
					$arrPermissionClasses = array();
					if ($upload_privilege == 'Y') {
						$arrPermissionClasses[] = 'upload';
					}
					$permissionClassList = join(' ',$arrPermissionClasses);
				}
                $tmpUserCompany = new UserCompany($database);
                $key = array('id' => $RN_user_company_id);
                $tmpUserCompany->setKey($key);
                $tmpUserCompany->load();
                $tmpUserCompany->convertDataToProperties();
                $user_company_name = $tmpUserCompany->user_company_name;
                $formattedName = htmlspecialchars_decode($user_company_name);
                $formattedName= html_entity_decode($user_company_name, ENT_QUOTES, "UTF-8");
                $companyFolder=array();
                $companyFolder['name']=$formattedName.' Company Files ';
                $companyFolder['id']=$tmpUserCompany->user_company_id;
                $companyFolder['folder_id']=$id;
                $companyFolder['isFolder']=true;
                $companyFolder['isFile']=false;
                $companyFolder['isCompany']=true;
                $companyFolder['permissionClassList']=$permissionClassList;
                array_push($list,$companyFolder);
            }
            if ($currentlySelectedProjectFoldersExistFlag) {
                $id = $rootCurrentlySelectedProject_file_manager_folder_id;
                $permissionClassList = '';
                $showTheProjectFolder = false;
				$arrFolderPermissionsMatrix = FileManagerFolder::loadPermissionsMatrixByIdList($database, array($id), $RN_project_id, $permissions);
                if (
					isset($arrFolderPermissionsMatrix) && !empty($arrFolderPermissionsMatrix) &&
					isset($arrFolderPermissionsMatrix[$id]) && !empty($arrFolderPermissionsMatrix[$id])
				) {
					$showTheProjectFolder = true;
					$upload_privilege = $arrFolderPermissionsMatrix[$id]['upload_privilege'];
					$arrPermissionClasses = array();
					if ($upload_privilege == 'Y') {
						$arrPermissionClasses[] = 'upload';
					}
					$permissionClassList = join(' ',$arrPermissionClasses);
                }
                if($showTheProjectFolder){
                    $formattedName = htmlspecialchars_decode($RN_currentlySelectedProjectName);
                    $formattedName= html_entity_decode($RN_currentlySelectedProjectName, ENT_QUOTES, "UTF-8");
                    $projectFolder=array();
                    $projectFolder['name']=$formattedName .' ('.$user_company_name.' Project Files) ';
                    $projectFolder['id']=$RN_project_id;
                    $projectFolder['folder_id']=$id;
                    $projectFolder['isFolder']=true;
                    $projectFolder['isFile']=false;
                    $projectFolder['isProject']=true;
                    $projectFolder['permissionClassList']=$permissionClassList;
                    $arrayList=getFilesByNodeId($id,false,false,$permissions,$user,$RN_userRole,$database, $RN_project_id);
                    $projectFolderExist=count($arrayList)>0? true:false;
                    foreach ($arrayList as $key => $value) {
                        $value['projectFolder']=true;
                        array_push($list,$value);
                    }
                }
            }
            	
            if ($currentlySelectedProjectOwnedByOtherFoldersExistFlag) {
                $id = $rootCurrentlySelectedProjectOwnedByOther_file_manager_folder_id;
                $showTheProjectFolder = false;
				$permissionClassList = '';
				$arrFolderPermissionsMatrix = FileManagerFolder::loadPermissionsMatrixByIdList($database, array($id), $RN_project_id, $permissions);
				if (
						isset($arrFolderPermissionsMatrix) && !empty($arrFolderPermissionsMatrix) &&
						isset($arrFolderPermissionsMatrix[$id]) && !empty($arrFolderPermissionsMatrix[$id])
				) {
					$showTheProjectFolder = true;
					$upload_privilege = $arrFolderPermissionsMatrix[$id]['upload_privilege'];
					$arrPermissionClasses = array();
					if ($upload_privilege == 'Y') {
						$arrPermissionClasses[] = 'upload';
					}
					$permissionClassList = join(' ',$arrPermissionClasses);
                }
                if($showTheProjectFolder){
                    $formattedName = htmlspecialchars_decode($RN_currentlySelectedProjectName);
                $formattedName= html_entity_decode($RN_currentlySelectedProjectName, ENT_QUOTES, "UTF-8");
                    $projectFolder=array();
                    $projectFolder['name']=$formattedName .' ('.$user_company_name.' Project Files) ';
                    $projectFolder['id']=$RN_project_id;
                    $projectFolder['isFolder']=true;
                    $projectFolder['folder_id']=$id;
                    $projectFolder['isFile']=false;
                    $projectFolder['isProject']=true;
                    $projectFolder['permissionClassList']=$permissionClassList;
                    $arrayList=getFilesByNodeId($id,false,false,$permissions,$user,$RN_userRole,$database, $RN_project_id);
                    $projectFolderExist=count($arrayList)>0? true:$projectFolderExist;
                    foreach ($arrayList as $key => $value) {
                        $value['projectFolder']=true;
                        array_push($list,$value);
                    }
                   
                }
            }
            $displayTrash = false;
            $id = '-1';
            if (!empty($arrTrashFolders) || !empty($arrTrashFiles)) {
                $displayTrash = true;
            }
            if($displayTrash){
                $displayTrashFolder=array();
                $displayTrashFolder['name']='Trash';
                $displayTrashFolder['id']=$id;
                $displayTrashFolder['displayTrash']=$displayTrash;
                $displayTrashFolder['folder_id']=-1;
                $displayTrashFolder['isFolder']=true;
                $displayTrashFolder['isFile']=false;
                array_push($list,$displayTrashFolder);
            }
        }
        // $projectList=getProjectList($database, $RN_userRole, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);
        $finalFolderList=array();
        foreach ($list as $key => $value) {

            $arrayList=array();
            $isTrash = isset($value['displayTrash']) && $value['displayTrash'] ? true : false;
            if($value['isFolder'] ){
                $file_manager_folder_id = Data::parseInt($value['folder_id']);
                if($isTrash){
                    $arrayList=getTrashFolders($database, $file_manager_folder_id,$isTrash,false,$permissions,$RN_user_company_id,$currentlySelectedProjectUserCompanyId,$RN_project_id,$user,true);
                }else{
                    $arrayList=getFilesByNodeId($file_manager_folder_id,false,false,$permissions,$user,$RN_userRole,$database, $RN_project_id,false,true);
                }
            }
            $value['listCount']=count($arrayList);
            if(($value['isFile'] && $value['fileAccess']) || $value['isFolder']){
                array_push($finalFolderList,$value);
            }
        }
        $RN_jsonEC['data']['list'] =$finalFolderList;
        // $RN_jsonEC['data']['projectList'] =$projectList;
        $RN_jsonEC['data']['projectId'] =$RN_project_id;
        $RN_jsonEC['data']['projectName'] =$RN_project_name;
        $RN_jsonEC['data']['projectFolderExist'] =$projectFolderExist;
        
}
catch(Exception $e){
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
