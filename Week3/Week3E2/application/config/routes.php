<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['pages/(:any)'] = 'details/viewDinosaurs/$1';
$route['(:any)'] = 'details/viewDinosaurs/$1';
$route['dinosaursdetails'] = 'pages/dinosaursdetails';
$route['default_controller'] = 'details/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
