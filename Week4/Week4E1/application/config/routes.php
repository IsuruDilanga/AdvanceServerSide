<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['view'] = 'pages/view';
$route['pages/(:any)'] = 'genre/viewGenreDetails/$1';
$route['(:any)'] = 'genre/viewGenreDetails/$1';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
