<?php
$uri = Zend_Registry::get('uri');
// $currentPhpScript = '/' . $uri->currentPhpScript;
$currentPhpScript = $uri->path;
//echo $currentPhpScript;
$session = Zend_Registry::get('session');
$actualUserRole = $session->getActualUserRole();
//echo $actualUserRole;
$debugMode = (bool) $session->getDebugMode();
//$database = Zend_Registry::get('database');
//$db = DBI::getInstance($database);


// Check if user has access to this script
// Comment out for now
/*
if (!isset($arrSoftwareModuleUrls[$currentlyRequestedUrl]) && !isset($arrSoftwareModuleFunctionUrls[$currentlyRequestedUrl]) {
	$user_id = $session->getUserId();

	if ((isset($user_id) && ($user_id > 0)) && ($currentPhpScript != "/account.php")) {
		//$url = '/account.php'.$uri->queryString;
		$url = '/account.php';
		header('Location: '.$url);
	} else {
		$url = '/';
		header('Location: '.$url);
	}
}
*/


$permissions = Zend_Registry::get('permissions');
/* @var $permissions Permissions */

$arrNavigation = $permissions->getArrNav();

$arrNavigationActive = $permissions->getArrNavActive();

if (count($arrNavigation) == 0) {
	return;
}

$arrSoftwareModuleCategorySortOrder = $permissions->getArrSoftwareModuleCategorySortOrder();
//ksort($arrNavigation);
//asort($arrSoftwareModuleCategorySortOrder);

ob_start();
echo
'<div id="navBoxModuleGroup" class="sidebarBox moduleNavBox">
													<div class="arrowlistmenu">';

$projectAdminIncludedFlag = false;
$cnt='0';
foreach ($arrSoftwareModuleCategorySortOrder as $software_module_category_id => $software_module_category_sort_order) {
	// Not all permissions may be set in the Menu/Navigation
	if (!isset($arrNavigation[$software_module_category_id]['name'])) {
		continue;
	}
	$arrTempNamActive = $arrNavigationActive[$software_module_category_id];
	// Menu default Show to check the site settings
	$activeSoftwareDefault = '';
	$classActiveHeader = '';
	if (in_array($currentPhpScript, $arrTempNamActive)) {
		$activeSoftwareDefault = 'style="display: block;"';
		$classActiveHeader = 'openheader2';
	}
	
	//echo $arrNavigation[$software_module_category_id]['name'];
	$software_module_category_label = $arrNavigation[$software_module_category_id]['name'];
	//echo $software_module_category_label; //MENU NAME
	echo
'<div class="menuheader expandable2 '.$classActiveHeader.'">' . $software_module_category_label . '</div>
														<ul class="categoryitems2" id="'.$cnt.'c" '.$activeSoftwareDefault.'>';

	$arrSoftwareModules = $arrNavigation[$software_module_category_id]['modules'];
	//echo $arrSoftwareModules;  //array
	$softwareModulesCount = count($arrSoftwareModules);
	//echo $softwareModulesCount;// 7 1 2 7
	foreach ($arrSoftwareModules AS $software_module_id => $arrSoftwareModule) {
		$software_module_label = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['name'];
		//echo $software_module_label; //SUBMENU NAME

		// Skip Create A New Project if Projects Admin is a vailable
		if ($software_module_label == 'Projects Admin') {
			$projectAdminIncludedFlag = true;
		}
		if ($projectAdminIncludedFlag) {
			if ($software_module_label == 'Create A New Project') {
				continue;
			}
		}

		// We can't just get the function keys because some functions might not be tagged to display in the navigation
		// Therefore we need to loop through the function keys and see if it is set to display in the navigation
		// and then build the $arrSoftwareModuleFunctionIds array manually.
		$arrSoftwareModuleFunctionIdsTmp = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'];
		//echo $arrSoftwareModuleFunctionIdsTmp; 
		$arrSoftwareModuleFunctionIds = array();
		foreach ($arrSoftwareModuleFunctionIdsTmp AS $software_module_function_id => $arrSoftwareModuleFunction) {
			$show_in_navigation_flag = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['show'];
			if ($show_in_navigation_flag == 'Y') {
				$arrSoftwareModuleFunctionIds[] = $software_module_function_id;
			}
		}
		//echo $eee = count($arrSoftwareModuleFunctionIds);
		$softwareModuleFunctionIdsCount = count($arrSoftwareModuleFunctionIds);
		//echo $softwareModuleFunctionIdsCount;
		if ($softwareModuleFunctionIdsCount > 1) {
			if ($softwareModulesCount > 1) {
echo'
<li><a href="#" class="moduleStyle">'.$software_module_label.'</a>
	<ul class="moduleFunctions">';
		}
		foreach ($arrSoftwareModuleFunctionIds AS $software_module_function_id) {
				$software_module_function_navigation_label = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['label'];
				$default_software_module_function_url = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['path'];
				//echo $default_software_module_function_url;
				//echo $software_module_function_navigation_label;//chagepassword,changelogin info
				$selectedFunctionImg = '';
				$selectedFunction = '';
if ($currentPhpScript == $default_software_module_function_url) {
					$selectedFunctionImg =
'	<img id="iselected_'.$software_module_function_id.'" alt="" src="/images/navigation/left-nav-arrow-green.gif">';
					$selectedFunction = ' selectedFunction';
				}
				//echo '<li><a href="'.$default_software_module_function_url.'" class="functionStyle">'. substr($software_module_function_navigation_label,0,18) .'</a></li>';
				if ($softwareModulesCount > 1) {
echo'
	<li id="menu_i_'.$software_module_function_id.'"><a onmouseover="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'show\');" onmouseout="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'hide\');" href="'.$default_software_module_function_url.'" class="functionStyle'.$selectedFunction.'">'.$software_module_function_navigation_label.'<img id="i_'.$software_module_function_id.'" class="invisible" alt="" src="/images/navigation/left-nav-arrow-green.gif">'.$selectedFunctionImg.'</a></li>';
				} else {
					echo'
	<li id="menu_i_'.$software_module_function_id.'"><a onmouseover="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'show\');" onmouseout="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'hide\');" href="'.$default_software_module_function_url."?pID=".$_GET['pID'].'" class="moduleLikeFunctionStyle'.$selectedFunction.'">'.$software_module_function_navigation_label.'<img id="i_'.$software_module_function_id.'" class="invisible" alt="" src="/images/navigation/left-nav-arrow-green.gif">'.$selectedFunctionImg.'</a></li>';
				}
			}
			if ($softwareModulesCount > 1) {
				echo
'</ul></li>';
			}
		} else{
		// elseif ($softwareModuleFunctionIdsCount == 1) {

			$software_module_function_navigation_label = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['label'];
			$default_software_module_function_url = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['path'];
			$selectedFunctionImg = '';
			$selectedFunction = '';
			if ($currentPhpScript == $default_software_module_function_url) {
				$selectedFunctionImg =
'
	<img id="iselected_'.$software_module_function_id.'" alt="" src="/images/navigation/left-nav-arrow-green.gif">';
				$selectedFunction = ' selectedFunction';
			}
			if ($currentPhpScript == $default_software_module_function_url) {
				$activeSoftwareDefault = 'style="display: block;"';
				$classActiveHeader = 'openheader2';
			}
			//echo '<li><a href="'.$default_software_module_function_url.'" class="functionStyle">'. substr($software_module_function_navigation_label,0,18) .'</a></li>';
			echo
'<li id="menu_i_'.$software_module_function_id.'"><a onmouseover="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'show\');" onmouseout="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'hide\');" href="'.$default_software_module_function_url."?pID=".$_GET['pID'].'" class="moduleLikeFunctionStyle'.$selectedFunction.'">'.$software_module_function_navigation_label.'<img id="i_'.$software_module_function_id.'" class="invisible" alt="" src="/images/navigation/left-nav-arrow-green.gif">'.$selectedFunctionImg.'</a></li>';

		} 
// 		else {
// 			$default_software_module_url = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['path'];
// 			echo
// '<li><a href="'.$default_software_module_url.'">'.$software_module_label.'</a></li>';
// 		}
	}
	echo
'</ul>';
$cnt++;
}
echo
'</div></div>';
//	<div style="text-align: center; padding: 5px 0;"><img alt="" src="/images/navigation/left-nav-block-gradient.gif"></div>
//';

// Debug Information
if (($actualUserRole == 'global_admin') && $debugMode) {
	//echo "<pre>$uri</pre>";
	//ob_start();
	$database = Zend_Registry::get('database');
	//$db = DBI::getInstance($database);
	$session = Zend_Registry::get('session');
	/* @var $session Session */

	// "My/My Company Information"
	$user_company_id = $session->getUserCompanyId();
	$user_id = $session->getUserId();
	$primary_contact_id = $session->getPrimaryContactId();
	$userRole = $session->getUserRole();

	// "Project-driven Information"
	// My Company may or may not own the project
	$currentlySelectedProjectUserCompanyId = (int)$session->getCurrentlySelectedProjectUserCompanyId();
	$currentlySelectedProjectId = (int)$session->getCurrentlySelectedProjectId();
	$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
	$currentlyActiveContactId = (int)$session->getCurrentlyActiveContactId();
	$primary_contact_id = $session->getPrimaryContactId();

	echo "<div style=\"background-color: #f0f0f0; padding: 0px;\"><small style=\"font-size: 70%;\">";
	echo "[Debug]<br>";

	echo "--- Registered User Data Begin ---<br>";
	$tmpUserCompany = new UserCompany($database);
	$key = array('id' => $user_company_id);
	$tmpUserCompany->setKey($key);
	$tmpUserCompany->load();
	$tmpUserCompany->convertDataToProperties();
	echo "user_company_id: " . $session->getUserCompanyId() . "<br>";
	echo "user_company_name: " . $tmpUserCompany->user_company_name . "<br>";
	echo "paying_customer_flag: " . $tmpUserCompany->paying_customer_flag . "<br>";
	echo "user_id: " . $user_id . "<br>";
	echo "primary_contact_id: " . $primary_contact_id . "<br>";
	echo "userRole: " . $userRole . "<br>";
	echo "email: " . $session->getLoginName() . "<br>";
	echo "--- Registered User Data End ---<br>";
	echo "<br>";

	echo '<div style="white-space: nowrap; width: 240px;">--- Currently Selected Project Data Begin ---</div><br>';
	$tmpUserCompany = new UserCompany($database);
	$key = array('id' => $currentlySelectedProjectUserCompanyId);
	$tmpUserCompany->setKey($key);
	$tmpUserCompany->load();
	$tmpUserCompany->convertDataToProperties();
	echo "currentlySelectedProjectId: " . $currentlySelectedProjectId . "<br>";
	echo "currentlySelectedProjectName: " . $currentlySelectedProjectName . "<br>";
	echo "currentlySelectedProjectUserCompanyId: " . $currentlySelectedProjectUserCompanyId . "<br>";
	echo "currentlySelectedProjectUserCompanyName: " . $tmpUserCompany->user_company_name . "<br>";
	echo "--- Currently Selected Project Data End ---<br>";
	echo "<br>";

	echo "--- Currently Active Contact Data Begin ---<br>";
	$tmpContactId = $session->getCurrentlyActiveContactId();
	$tmpContact = new Contact($database);
	$key = array('id' => $tmpContactId);
	$tmpContact->setKey($key);
	$tmpContact->load();
	$tmpContact->convertDataToProperties();
	echo "currentlyActiveContactId: " . $tmpContactId . "<br>";
	echo "currentlyActiveContactUserCompanyId: " . $tmpContact->user_company_id . "<br>";
	echo "email: " . $tmpContact->email . "<br>";
	echo "name: " . $tmpContact->getContactFullName() . "<br>";
	$tmpContactCompany = new ContactCompany($database);
	$tmpContactCompanyId = $tmpContact->contact_company_id;
	$key = array('id' => $tmpContactCompanyId);
	$tmpContactCompany->setKey($key);
	$tmpContactCompany->load();
	$tmpContactCompany->convertDataToProperties();
	echo "--- Contact Company ---<br>";
	echo "contact_company_id: " . $tmpContactCompany->contact_company_id . "<br>";
	echo "user_user_company_id: " . $tmpContactCompany->user_user_company_id . "<br>";
	echo "contact_user_company_id: " . $tmpContactCompany->contact_user_company_id . "<br>";
	echo "contact_company_name: " . $tmpContactCompany->contact_company_name . "<br>";
	echo "employer_identification_number: " . $tmpContactCompany->employer_identification_number . "<br>";
	echo "--- Currently Active Contact Data End ---<br>";
	//echo "<br>";

	echo "</small></div>";
	//$debugLeftVerticalMenu = ob_get_clean();
	//echo $debugLeftVerticalMenu;
} else {
	//echo '';
	echo
'
<div id="leftNavBottomDiv" style="min-height: 200px; text-align: center; padding: 5px 0;"></div>';
}

$navigationLeftVerticalMenu = ob_get_clean();
echo $navigationLeftVerticalMenu;
//$template->assign('navigationLeftVerticalMenu', $navigationLeftVerticalMenu);
