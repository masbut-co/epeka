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
$route['default_controller'] = 'lomba/band';
$route['voting-sukses'] = 'lomba/after_insert';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['balai'] = 'lomba/band/balai';
$route['balai/di'] = 'lomba/band/baalaikat';
$route['fashion-show'] = 'lomba/fashion_show';
$route['stand-up'] = 'lomba/stand_up';
$route['layanan'] = 'lomba/band/layanan';
$route['layanan2'] = 'lomba/band/keluhan';

$route['list-band'] = 'admin/daftar_band';
$route['list-fashion-show'] = 'admin/daftar_fashion';
$route['list-standup'] = 'admin/daftar_standup';
$route['answerform'] = 'admin/daftar_band/tindakLanjut';
$route['erorupload'] = 'admin/daftar_band/failupload';
$route['answerform/put'] = 'admin/daftar_band/tndklnjtact';
$route['listfilter'] = 'admin/Filter_daftar_band';

$route['hasil-band'] = 'admin/result_band';
// $route['hasil-band-bulanan'] = 'admin/Result_band_bulan';
$route['hasil-band-bulanan/getPerNamaKgtn'] = 'admin/Result_band_bulan/getPerNamaKgtn';
$route['hasil-band-bulanan/getKategori'] = 'admin/Result_band_bulan/getKategori';
$route['hasil-band-bulanan/getRekapKgtn'] = 'admin/Result_band_bulan/getRekapKgtn';
$route['hasil-band/getPerNamaKgtn'] = 'admin/result_band/getPerNamaKgtn';
$route['hasil-band/getKategori'] = 'admin/result_band/getKategori';
$route['hasil-band/getRekapKgtn'] = 'admin/result_band/getRekapKgtn';
$route['hasil-band/getUnsurPerRep'] = 'admin/result_band/getUnsurPerRep';

$route['user'] = 'admin/setting_user';
$route['user/add'] = 'admin/setting_user/addUser';

$route['user'] = 'admin/setting_user';
$route['user/add'] = 'admin/setting_user/addUser';
$route['user/delete'] = 'admin/setting_user/delUser';

$route['category'] = 'admin/api_sipar';
$route['categoryview'] = 'admin/setting_ktg';
$route['category/addKgt'] = 'admin/setting_ktg/addKgt';
$route['category/disablekgt'] = 'admin/setting_ktg/disablekgt';
$route['category/enablekgt'] = 'admin/setting_ktg/enablekgt';
$route['viewEditKtg'] = 'admin/set_edit_ktg';
$route['category/editkgt'] = 'admin/setting_ktg/editkgt';

$route['api/sync/balaisipar'] = 'admin/api_sipar';

$route['hasil-voting-band'] = 'lomba/hasil_band';
$route['hasil-voting-fashion'] = 'lomba/hasil_fashion';
$route['hasil-voting-standup'] = 'lomba/hasil_standup';

$route['login'] = 'admin/login';