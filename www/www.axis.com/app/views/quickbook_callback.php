<?php
/**
 * Quickbook Callback
 */

require "../vendor/quickbooks/vendor/autoload.php";
use QuickBooksOnline\API\DataService\DataService;


$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Message.php');
require_once('../models/accounting_model.php'); // Accounting Model


$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

// PERMISSION VARIABLES
$permissions = Zend_Registry::get('permissions');
/*Custome Permission call return value*/


$row =  getCompanyData($database, $user_company_id);

//print_r($row); //die;

/* Config Variables - QuickBooks */
$client_id = $row['client_id'];
$client_secret = $row['client_secret'];
$oauth_redirect_uri = $config->quickbook->oauth_redirect_uri;
$oauth_scope = $config->quickbook->oauth_scope;
$environment = $config->quickbook->environment;

/* Config Variables - QuickBooks */


$dataService = DataService::Configure(array(
				      'auth_mode' => 'oauth2',
				      'ClientID' => $client_id,
				      'ClientSecret' => $client_secret,
				      'RedirectURI' => $oauth_redirect_uri,
				      'scope' => $oauth_scope,
				      'baseUrl' => $environment
				));

$url = $_SERVER['QUERY_STRING'];
parse_str($url,$qsArray);

$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

$accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($qsArray['code'], $qsArray['realmId']);

$accessTokenJson = array(
						'token_type' => 'bearer',
					    'access_token' => $accessToken->getAccessToken(),
					    'refresh_token' => $accessToken->getRefreshToken(),
					    'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
					    'expires_in' => $accessToken->getAccessTokenExpiresAt(),
					    'realmID' => $qsArray['realmId']
					);
// print_r($accessTokenJson);

if(!empty($accessToken->getAccessToken()) && !empty($accessToken->getRefreshToken())){
	updateQBTokenDetails($database, $user_company_id, $accessTokenJson);
}

$session->setQuickbooks($accessTokenJson);
?>
