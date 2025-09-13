<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['login']='Login/index';
$route['logout']='Login/logout';

//$route['qr/:any']='QR/qrDetails';
$route['login/authenticate']='Login/authenticate';
$route['dashboard']='Login/dashBoard';
$route['Customer/create']='Customer/create';
$route['Customer/createDb']='Customer/createDb';

$route['Worker/create']='Worker/create'; //30 Jan 2024
$route['Worker/createDb']='Worker/createDb'; //30 Jan 2024

$route['Master/typeCreate']='Master/typeCreate'; //30 Jan 2024
$route['Master/typeCreateDb']='Master/typeCreateDb'; //30 Jan 2024


$route['Master/measurementCreate']='Master/measurementCreate'; //30 Jan 2024
$route['Master/measurementCreateDb']='Master/measurementCreateDb'; //30 Jan 2024

$route['Master/fashionCreate']='Master/fashionCreate'; //03 Feb 2024
$route['Master/fashionCreateDb']='Master/fashionCreateDb';

$route['Sales/salesCreate']='Sales/create'; //03 Feb 2024
$route['Sales/salesDb']='Sales/salesDb'; //03 Feb 2024

$route['Job/assignJob']='Job/assignJob'; //03 Feb 2024
$route['Job/assignCutter']='Job/assignCutter'; //03 Feb 2024

$route['Job/completeJob']='Job/completeJob'; //03 Feb 2024
$route['Job/jobReport']='Job/jobReport'; //03 Feb 2024

$route['Job/slipDesign']='Job/slipDesign'; 
$route['Job/slipDesignDb']='Job/slipDesignDb'; 
$route['Job/deliveryJob']='Job/deliveryJob'; 

$route['Sales/salesReport']='Sales/salesReport';//27 Feb 2024










/*
$route['qr/dashboard']='QR/dashBoard';
$route['qr/list']='QR/shortUrlList';
$route['qr/logReport']='QR/logReport';
$route['qr/createUrl']='QR/createUrl';
$route['qr/createlink']='QR/generateUrl';
$route['qr/logout']='QR/userLogout()';

$route['qr/qrDetailsLogin']='QR/qrEngineLoginDb';
$route['qr/qrDetailsFill']='QR/qrEngineForm';
$route['qr/qrDetailsFillDb']='QR/qrEngineFormDb';

$route['qr/qrDetails/:any']='QR/qrEngineLogin';

$route[':any'] = 'QR/shortenUrlCall';
*/