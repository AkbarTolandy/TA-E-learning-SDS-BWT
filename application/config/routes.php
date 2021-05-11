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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['administrador'] = 'administrador/Auth';

$route['login']['GET'] = 'administrador/Auth';
$route['logout']['GET'] = 'administrador/Auth/logout';
$route['login']['POST'] = 'administrador/Auth';

$route['register']['GET'] = 'administrador/Auth/registration';
$route['register']['POST'] = 'administrador/Auth/registration';

$route['forgot-password']['GET'] = 'administrador/Auth/forgotPassword';
$route['forgot-password']['POST'] = 'administrador/Auth/forgotPassword';

$route['user']['GET'] = 'administrador/User';
$route['user/edit']['GET'] = 'administrador/User/edit';
$route['user/edit']['POST'] = 'administrador/User/edit';
$route['user/change-password']['GET'] = 'administrador/User/changePassword';
$route['user/change-password']['POST'] = 'administrador/User/changePassword';

$route['administrador/admin/role-access/(:num)'] = 'administrador/Admin/roleAccess/$1';
$route['administrador/admin/change-access'] = 'administrador/Admin/changeAccess';
$route['administrador/user/change-password'] = 'administrador/User/changePassword';
$route['administrador/auth/forgot-password'] = 'administrador/Auth/forgotPassword';
$route['administrador/auth/reset-password'] = 'administrador/Auth/resetPassword';
$route['administrador/auth/change-password'] = 'administrador/Auth/changePassword';

#data menu
$route['administrador/menu/show/(:num)'] = 'administrador/Menu/editMenu/$1';
$route['administrador/menu/destroy/(:num)'] = 'administrador/Menu/deleteMenu/$1';

$route['administrador/city/show/(:num)'] = 'administrador/City/editCity/$1';
$route['administrador/city/destroy/(:num)'] = 'administrador/City/deleteCity/$1';

#data role
$route['administrador/role/edit/(:num)'] = 'administrador/Role/edit/$1';
$route['administrador/role/delete/(:num)'] = 'administrador/Role/delete/$1';

#data category
$route['administrador/category/edit/(:num)'] = 'administrador/Category/edit/$1';
$route['administrador/category/delete/(:num)'] = 'administrador/Category/delete/$1';

$route['katalog']['GET'] = 'administrador/katalog';
$route['katalog/get-video/(:any)']['GET'] = 'administrador/katalog/get_video/$1';

$route['katalog/(:any)']['GET'] = 'administrador/katalog/detail/$1';
$route['administrador/katalog/(:any)']['GET'] = 'administrador/katalog/detail/$1';

$route['course/online/(:any)']['GET'] = 'administrador/course/online_detail/$1';
$route['administrador/course/online/(:any)']['GET'] = 'administrador/course/online_detail/$1';

$route['katalog/(:any)/video/(:any)']['GET'] = 'administrador/katalog/videos/$1/$2';

$route['kelas']['GET'] = 'administrador/kelas';
$route['kelas/premium']['GET'] = 'administrador/kelas/premium';

$route['karya']['GET'] = 'administrador/karya';
$route['administrador/karya/upload-karya']['GET'] = 'administrador/karya/submit_karya';
$route['administrador/karya/upload-karya']['POST'] = 'administrador/karya/submit_karya';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['api/user/forgot-password']['POST'] = 'api/user/forgotPassword';
$route['api/user/change-password']['POST'] = 'api/user/changePassword';
$route['api/user/reset-password'] = 'api/user/resetPassword';

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
