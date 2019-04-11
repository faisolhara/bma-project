<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'language'], function(){
	Route::get('/', function () {
	    return view('login');
	});

	Route::post('/login', 'AdminController@login');

	Route::group(['middleware' => ['customAuth', 'menu']], function(){
		Route::get('/logout', 'AdminController@logout');
		Route::get('/dashboard', 'DashboardController@index');
		Route::get('/setting', 'DashboardController@viewSetting');
		Route::post('/save-setting', 'DashboardController@saveSetting');

		Route::group(['prefix' => 'master-user'], function() {
			Route::get('/', 'MasterUserController@index');
			Route::post('/save', 'MasterUserController@save');
			Route::post('/reset-password', 'MasterUserController@resetPassword');
		});

		Route::group(['prefix' => 'notification'], function() {
			Route::any('/', 'NotificationController@index');
			Route::get('/read/{id}', 'NotificationController@read');
			Route::post('/get-notification', 'NotificationController@getNotification');
		});

		Route::group(['prefix' => 'master-tenant'], function() {
			Route::get('/', 'MasterTenantController@index');
			Route::post('/save', 'MasterTenantController@save');
		});

		Route::group(['prefix' => 'master-unit'], function() {
			Route::get('/', 'MasterUnitController@index');
			Route::post('/save', 'MasterUnitController@save');
		});

		Route::group(['prefix' => 'master-subunit'], function() {
			Route::get('/', 'MasterSubunitController@index');
			Route::post('/save', 'MasterSubunitController@save');
		});

		Route::group(['prefix' => 'master-room'], function() {
			Route::get('/', 'MasterRoomController@index');
			Route::post('/save', 'MasterRoomController@save');
		});

		Route::group(['prefix' => 'master-department'], function() {
			Route::get('/', 'MasterDepartmentController@index');
			Route::post('/save', 'MasterDepartmentController@save');
		});

		Route::group(['prefix' => 'master-facility'], function() {
			Route::get('/', 'MasterFacilityController@index');
			Route::post('/save', 'MasterFacilityController@save');
		});

		Route::group(['prefix' => 'view-suggest'], function() {
			Route::any('/', 'ViewSuggestController@index');
		});

		Route::group(['prefix' => 'complaint'], function() {
			Route::any('/', 'ComplaintController@index');
			Route::post('/save', 'ComplaintController@save');
		});

		Route::group(['prefix' => 'suggest'], function() {
			Route::any('/', 'SuggestController@index');
			Route::post('/save', 'SuggestController@save');
		});

		Route::group(['prefix' => 'report1'], function() {
			Route::get('/', 'ReportByDept@index');
			Route::post('/getData', 'ReportByDept@getData');
		});

		Route::group(['prefix' => 'report2'], function() {
			Route::get('/', 'ReportBySubordinat@index');
			Route::post('/getData', 'ReportBySubordinat@getData');
		});

		Route::group(['prefix' => 'report3'], function() {
			Route::get('/', 'ReportSubordinatScore@index');
			Route::post('/getData', 'ReportSubordinatScore@getData');
		});

		Route::group(['prefix' => 'report4'], function() {
			Route::get('/', 'ReportTechnician@index');
			Route::post('/getData', 'ReportTechnician@getData');
		});

		Route::post('/set-player-id-employee', 'CommonController@setPlayerIdEmployee');

		Route::group(['prefix' => 'json', 'before' => 'auth.basic'], function() {
			Route::post('/get-employee-index', 'ApiController@getEmployeeIndex');
			Route::post('/get-employee', 'ApiController@getEmployee');
			Route::post('/get-employee-detail-unit', 'ApiController@getEmployeeDetailUnit');
			Route::post('/get-supervised', 'ApiController@getEmployee');
			Route::post('/get-tenant', 'ApiController@getTenant');
			Route::post('/get-unit', 'ApiController@getUnit');
			Route::post('/get-subunit', 'ApiController@getSubunit');
			Route::post('/get-detail-unit', 'ApiController@getDetailUnit');
			Route::post('/get-detail-unit-by-room', 'ApiController@getDetailUnitByRoom');
			Route::post('/get-room-index', 'ApiController@getRoomIndex');
			Route::post('/get-room', 'ApiController@getRoom');
			Route::post('/get-department', 'ApiController@getDepartment');
			Route::post('/get-facility', 'ApiController@getFacility');
			Route::post('/get-complaint-index', 'ApiController@getComplaintIndex');
			Route::post('/get-complaint', 'ApiController@getComplaint');
			Route::post('/get-hist-trans', 'ApiController@getHistTrans');
			Route::post('/get-suggest', 'ApiController@getSuggest');
			Route::post('/get-suggest-index', 'ApiController@getSuggestIndex');
		});
	});
});
