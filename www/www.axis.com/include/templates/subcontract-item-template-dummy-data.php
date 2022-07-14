<?php
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

if (!isset($uri->http)) {
	$uri->http = 'http://localdev.axis.com/';
}

$page_count = 11;
$costCodeLabel = '06-411 Cabinets';

$city_business_license_required_flag = 'Y';

$project_name = 'Olympic Pointe (West)';
$project_address_line_1 = '33302 Valle Road Suite 125';
$project_address_city = 'San Juan Capistrano';
$project_address_state_or_region = 'CA';
$project_address_postal_code = '92675';
$project_phone_number = '(949) 582-2044';
$project_fax_number = '(949) 582-2041';

$general_contractor_address_line_1 = '33302 Valle Road Suite 125';
$general_contractor_address_city = 'San Juan Capistrano';
$general_contractor_address_state_or_region = 'CA';
$general_contractor_address_postal_code = '92675';
$general_contractor_phone_number = '(949) 582-2044';
$general_contractor_fax_number = '(949) 582-2041';

$customer_contact_name = 'Brett Campbell';
$customer_contact_phone_number = '(949) 582-2044';
$customer_contact_email = 'bcampbell@adventcompanies.com';

// @todo Fix this
$customer_address_line_1 = $general_contractor_address_line_1;
$customer_address_city = $general_contractor_address_city;
$customer_address_state_or_region = $general_contractor_address_state_or_region;
$customer_address_postal_code = $general_contractor_address_postal_code;
$customer_phone_number = $general_contractor_phone_number;
$customer_fax_number = $general_contractor_fax_number;

$division_number = '01';
$cost_code = '512';
$cost_code_description = 'Drinking Water';
$general_contractor_company_name = 'Advent';
$subcontract_actual_value = '30900.00';
$vendor_company_name = 'RCI Plumbing';
$vendor_contact_name = 'RCI Plumbing';
$vendor_address_line_1 = '100 Circle Square';
$vendor_address_line_2 = 'Line #2';
$vendor_address_city = 'Elko';
$vendor_address_state_or_region = 'NV';
$vendor_address_postal_code = '89801';
$vendor_phone_number = '(702) 555-1234';
$vendor_fax_number = '(702) 555-6789';
$vendor_contact_name = 'Mike Plumber';
