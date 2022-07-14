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

require_once('Project_tag_functions.php');
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

   
      case 'DeleteTags':
      $id = $get->id;
      $result =  deleteTags($database,$id);
      echo $result;
      break;

       case 'updateTagName':

      $tag_id = $get->tag_id;
      $tag_name = $get->tag_name;
      $retdata = updateTagName($tag_id,$tag_name);
       
      echo $retdata;
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
