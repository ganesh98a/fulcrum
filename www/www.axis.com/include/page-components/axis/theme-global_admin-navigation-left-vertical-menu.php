<?php
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

if (count($arrNavigation) == 0) {
	return;
}

$arrSoftwareModuleCategorySortOrder = $permissions->getArrSoftwareModuleCategorySortOrder();
//ksort($arrNavigation);
//asort($arrSoftwareModuleCategorySortOrder);

ob_start();
echo
'
									<div id="navBoxModuleGroup" class="sidebarBox moduleNavBox">
										<div class="arrowlistmenu">';
foreach ($arrSoftwareModuleCategorySortOrder as $software_module_category_id => $software_module_category_sort_order) {
	// Not all permissions may be set in the Menu/Navigation
	if (!isset($arrNavigation[$software_module_category_id]['name'])) {
		continue;
	}
	$software_module_category_label = $arrNavigation[$software_module_category_id]['name'];
	echo '<div class="menuheader expandable2">' . $software_module_category_label . '</div>';
	echo '<ul class="categoryitems2">';

	$arrSoftwareModules = $arrNavigation[$software_module_category_id]['modules'];
	$softwareModulesCount = count($arrSoftwareModules);
	foreach ($arrSoftwareModules AS $software_module_id => $arrSoftwareModule) {
		$software_module_label = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['name'];

		// We can't just get the function keys because some functions might not be tagged to display in the navigation
		// Therefore we need to loop through the function keys and see if it is set to display in the navigation
		// and then build the $arrSoftwareModuleFunctionIds array manually.
		$arrSoftwareModuleFunctionIdsTmp = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'];
		$arrSoftwareModuleFunctionIds = array();
		foreach ($arrSoftwareModuleFunctionIdsTmp AS $software_module_function_id => $arrSoftwareModuleFunction) {
			$show_in_navigation_flag = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['show'];
			if ($show_in_navigation_flag == "Y") {
				$arrSoftwareModuleFunctionIds[] = $software_module_function_id;
			}
		}

		$softwareModuleFunctionIdsCount = count($arrSoftwareModuleFunctionIds);
		if ($softwareModuleFunctionIdsCount > 1) {
			if ($softwareModulesCount > 1) {
				echo '
					<li><a href="#" class="moduleStyle">'.$software_module_label.'</a>
						<ul class="moduleFunctions">
				';
			}
			foreach ($arrSoftwareModuleFunctionIds AS $software_module_function_id) {
				$software_module_function_navigation_label = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['label'];
				$default_software_module_function_url = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['path'];
				//echo '<li><a href="'.$default_software_module_function_url.'" class="functionStyle">'. substr($software_module_function_navigation_label,0,18) .'</a></li>';
				if ($softwareModulesCount > 1) {
					echo '<li><a onmouseover="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'show\');" onmouseout="showHideLeftNavImage(\'i_'.$software_module_function_id.'\', \'hide\');" href="'.$default_software_module_function_url.'" class="functionStyle">'.$software_module_function_navigation_label.'<img id="i_'.$software_module_function_id.'" class="invisible" alt="" src="/images/navigation/left-nav-arrow-green.gif"></a></li>';
				} else {
					echo '<li><a href="'.$default_software_module_function_url."?pID=".$_GET['pID'].'" class="moduleLikeFunctionStyle">'.$software_module_function_navigation_label.'<img id="i_'.$software_module_function_id.'" class="invisible" alt="" src="/images/navigation/left-nav-arrow-green.gif"></a></li>';
				}
			}
			if ($softwareModulesCount > 1) {
				echo '
						</ul>
					</li>
				';
			}
		} elseif ($softwareModuleFunctionIdsCount == 1) {

			$software_module_function_navigation_label = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['label'];
			$default_software_module_function_url = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['path'];
			//echo '<li><a href="'.$default_software_module_function_url.'" class="functionStyle">'. substr($software_module_function_navigation_label,0,18) .'</a></li>';
			echo '<li><a href="'.$default_software_module_function_url."?pID=".$_GET['pID'].'" class="moduleLikeFunctionStyle">'.$software_module_function_navigation_label.'<img id="i_'.$software_module_function_id.'" class="invisible" alt="" src="/images/navigation/left-nav-arrow-green.gif"></a></li>';

		} else {
			$default_software_module_url = $arrNavigation[$software_module_category_id]['modules'][$software_module_id]['path'];
			echo '<li><a href="'.$default_software_module_url.'">'.$software_module_label.'</a></li>';
		}
	}


	echo '</ul>';
}
echo '
		</div>
	</div>
';
//	<div style="text-align: center; padding: 5px 0;"><img alt="" src="/images/navigation/left-nav-block-gradient.gif"></div>
//';
$navigationLeftVerticalMenu = ob_get_clean();
echo $navigationLeftVerticalMenu;
//$template->assign('navigationLeftVerticalMenu', $navigationLeftVerticalMenu);

// Comment out the below return statement to see the Debug Information
//return;

//echo "<pre>$uri</pre>";

$session = Zend_Registry::get('session');
$debugMode = (bool) $session->getDebugMode();
if ($debugMode) {
//if ($actualUserRole == "global_admin") {
	ob_start();
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
	echo "Full Name: " . $tmpContact->getContactFullName() . "<br>";
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
	$debugLeftVerticalMenu = ob_get_clean();
	echo $debugLeftVerticalMenu;
}
//}
