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

Route::get('/', function () {
	if(Auth::guard('web')->check())
	{
		return redirect()->route('employee');
	}
    return view('login');
});

Route::post('/login',[
	'as'=>'check_login',
	'uses'=>'LoginController@check_login'
]);

Route::get('/employee',[
	'as'=>'employee',
	'uses'=>'EmployeeController@index'
]);

Route::post('/emp_save',[
	'as'=>'save_employee_data',
	'uses'=>'EmployeeController@save_employee_data'
]);

Route::post('/emp_list_data',[
	'as'=>'showAjaxEmpInfo',
	'uses'=>'EmployeeController@showAjaxEmpInfo'
]);

Route::get('/emp_delete_data/{id}',[
	'as'=>'DeleteAjaxEmpInfo',
	'uses'=>'EmployeeController@DeleteAjaxEmpInfo'
]);

Route::get('/edit_delete_data',[
	'as'=>'EditAjaxEmpInfo',
	'uses'=>'EmployeeController@EditAjaxEmpInfo'
]);

Route::post('/emp_update_data',[
	'as'=>'upadteEmpInformation',
	'uses'=>'EmployeeController@upadteEmpInformation'
]);

Route::get('logout',[
	'as'=>'logout',
	'uses'=>'LoginController@logout'
]);









