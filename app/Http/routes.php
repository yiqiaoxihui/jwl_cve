<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// 密码重置链接请求路由...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// 密码重置路由...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/', 'IndexController@home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('home', 'IndexController@home');//
   
});
// Route::get('home', function () {

//     return view('home/yktrend');
// });


Route::group(['middleware' => 'auth','namespace' => 'Admin'], function() {  
       
});
//漏洞库
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'admin'], function() {  
    Route::get('/', 'HomeController@index');
    Route::get('cveToday', 'HomeController@cve_today');
    Route::post('addCve', 'HomeController@cve_add');
    Route::get('cveEdit/{id}', 'HomeController@cve_edit');
    Route::post('cveEditOk', 'HomeController@cve_edit_ok');
    Route::post('cveDelete', 'HomeController@cve_edit_ok');

    Route::get('cnvd', 'HomeController@cnvd');
    Route::post('addCnvd', 'HomeController@cnvd_add');
    Route::get('cnvdEdit/{id}', 'HomeController@cnvd_edit');
    Route::post('cnvdEditOk', 'HomeController@cnvd_edit_ok');
    Route::post('cnvdDelete', 'HomeController@cnvd_delete');

});
//补丁库
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'patch'], function() {  
    //
    Route::get('patch', 'PatchController@patch');
    Route::post('patchAdd', 'PatchController@patch_add');
    
    Route::get('patchEdit/{id}', 'PatchController@patch_edit');
    Route::post('patchEditOk', 'PatchController@patch_edit_ok'); 
    Route::post('patchDelete', 'PatchController@patch_delete'); 
});
//规则库
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'rule'], function() {  
    //
    Route::get('/', 'RulesController@rule');
    Route::post('ruleAdd', 'RulesController@ruleAdd');

    Route::get('ruleEdit/{id}', 'RulesController@ruleEdit');
    Route::post('ruleEditOk', 'RulesController@ruleEditOk'); 
    Route::post('ruleDelete', 'RulesController@ruleDelete');
    Route::get('newScan/{id}', 'RulesController@newScan');
    Route::post('launchScanOk', 'RulesController@launchScanOk'); 
});

//扫描库
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'scan'], function() {  
    //
    Route::get('newScan/{id}', 'ScansController@newScan');
    Route::post('launchScanOk', 'ScansController@launchScanOk'); 
    Route::get('scanControl', 'ScansController@scanControl');
    Route::get('scanRecord', 'ScansController@scanRecord');
    Route::post('scanDelete', 'ScansController@scanDelete');
});
//
// Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'image'], function() {  
    
//     Route::get('base', 'ImagesController@base');
//     Route::post('baseAdd', 'ImagesController@baseAdd');
//     Route::get('baseEdit/{id}', 'ImagesController@baseEdit');
//     Route::post('baseEditOk', 'ImagesController@baseEditOk'); 
//     Route::post('baseStart', 'ImagesController@baseStart');
//     Route::post('baseStop', 'ImagesController@baseStop'); 
//     Route::post('baseDelete', 'ImagesController@baseDelete'); 
   
//     Route::get('overlay', 'ImagesController@overlay');
//     Route::get('overlay/{base_id}', 'ImagesController@overlayChoose');
//     Route::post('overlayAdd', 'ImagesController@overlayAdd');
//     Route::get('overlayEdit/{id}', 'ImagesController@overlayEdit');
//     Route::post('overlayEditOk', 'ImagesController@overlayEditOk');   
//     Route::post('getBaseimageByServer', 'ImagesController@getBaseimageByServer');   
//     Route::post('overlayStart', 'ImagesController@overlayStart');
//     Route::post('overlayStop', 'ImagesController@overlayStop'); 
//     Route::post('overlayDelete', 'ImagesController@overlayDelete'); 

// });
//
// Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'file'], function() {  
//     //
//     Route::get('fileInfo', 'FilesController@fileInfo');
//     Route::get('fileInfo/{overlay_id}', 'FilesController@fileInfoChoose');
//     Route::post('fileAdd', 'FilesController@fileAdd');
//     //detect
    
//     Route::post('fileRestore', 'FilesController@fileRestore');
//     Route::post('fileRestoreCancel', 'FilesController@fileRestoreCancel');
//     Route::post('fileStart', 'FilesController@fileStart');
//     Route::post('fileStop', 'FilesController@fileStop');
//     Route::get('fileEdit/{id}', 'FilesController@fileEdit');
//     Route::post('fileEditOk', 'FilesController@fileEditOk'); 
//     Route::post('fileDelete', 'FilesController@fileDelete');
//     Route::post('getBaseimageByServer', 'FilesController@getBaseimageByServer');
//     Route::post('getOverlayByBase', 'FilesController@getOverlayByBase');
//     //
//     Route::get('fileRestoreInfo', 'FilesController@fileRestoreInfo');
//     Route::post('fileReset', 'FilesController@fileReset');
//     Route::get('fileRestoreRecord', 'FilesController@fileRestoreRecord');
//     Route::get('fileRestoreRecord/{overlay_id}', 'FilesController@fileRestoreRecordChoose');
//     Route::get('fileScan', 'FilesController@fileScan');
//     Route::get('fileScanRecord', 'FilesController@fileScanRecord');
//     Route::post('fileScanStart', 'FilesController@fileScanStart');
//     Route::post('fileScanStop', 'FilesController@fileScanStop');
//     //Route::get('fileRestoreNew', 'FilesController@fileRestoreNew');
// });
// Route::group(['middleware' => 'auth','namespace' => 'Admin','prefix' => 'virus'], function() {  
//     //
//     Route::get('virus', 'VirusController@virus');
//     Route::post('virusAdd', 'VirusController@virusAdd');
//     Route::post('virusDelete', 'VirusController@virusDelete');
//     Route::get('virusEdit/{id}', 'VirusController@virusEdit');
//     Route::post('virusEditOk', 'VirusController@virusEditOk'); 
//     Route::get('virusRecord', 'VirusController@virusRecord');
//     Route::post('virusRecordDelete', 'VirusController@virusRecordDelete'); 


// });
//
// Route::group(['middleware' => 'auth','namespace' => 'Admin','prefix' => 'database'], function() {  
//     //
//     Route::get('dataBase', 'DatabaseController@dataBase');
//     Route::get('dataBaseEdit/{id}', 'DatabaseController@dataBaseEdit');
//     Route::post('dataBaseEditOk', 'DatabaseController@dataBaseEditOk'); 


// });
//
Route::group(['middleware' => 'auth','namespace' => 'Admin','prefix' => 'user'], function() {  
    //
    Route::get('userInfo', 'UsersController@userInfo');



});