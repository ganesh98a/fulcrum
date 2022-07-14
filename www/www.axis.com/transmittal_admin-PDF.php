<?php
/*Manually increase the execution time for pdf generation*/
ini_set('max_execution_time', 300);
ini_set("memory_limit", "1000M");
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
// date_default_timezone_set('Asian/kolkata');
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());

require_once('lib/common/init.php');
require_once("dompdf/dompdf_config.inc.php");
$db = DBI::getInstance($database);
//Get the session projectid & company id
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
$user_company_id = $session->getUserCompanyId();

/*GC logo*/
require_once('lib/common/Logo.php');
/*Fetch fulcrum Logo*/
$gcLogo = Logo::logoByUserCompanyIDUsingSoftlink($database,$user_company_id);
$fulcrum = Logo::logoByFulcrum();
$content = ($_POST['Content']);
$content = mb_convert_encoding($content, "HTML-ENTITIES", "UTF-8");
/*Initialize dompdf for render*/
$dompdf = new DOMPDF();

$content = ($content);
//replace ;&ldquo; &rdquo;
$content = preg_replace("/&ldquo;/",'"',$content);
$content = preg_replace("/&rdquo;/",'"',$content);
//Store the html data's
$htmlContent = <<<ENDHTML
<table width="100%" class="table-header">
	<tr>
		<td class="align-right">$fulcrum</td>
	</tr>
</table>
<hr/>
	$content
ENDHTML;
		
	//load the data into pdf
	$dompdf = new DOMPDF();
	$dompdf->load_html($htmlContent);
	$dompdf->set_paper('A4','portrait');
	$dompdf->render();
	echo base64_encode($dompdf->output());

ob_end_clean();
ob_start();  
	?>