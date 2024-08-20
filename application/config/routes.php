<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'LoginController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['DokterController/soap_form/(:num)/(:num)/(:num)/(:any)'] = 'DokterController/soap_form/$1/$2/$3/$4';
$route['DokterController/delete_soap/(:num)/(:num)/(:num)/(:any)'] = 'DokterController/delete_soap/$1/$2/$3/$4';
$route['soap/update/(:any)'] = 'SoapController/update/$1';
$route['LaboratoriumController/search_lab_tests'] = 'LaboratoriumController/search_lab_tests';




