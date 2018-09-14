<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Login/GoHome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['Unsubscribe/(:any)'] = 'Campaigns/unsubscribe/$1';
$route['Unsubscribe_action/(:any)'] = 'Campaigns/unsubscribeAction/$1';
$route['Abuse_action/(:any)'] = 'Campaigns/abuseAction/$1';
$route['Unsubscribed'] = 'Campaigns/unsubscribed';
$route['Marked_abuse'] = 'Campaigns/markedAbused';
