<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

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
    //return view('welcome');
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function () {

	Route::get('dashboard', function () {
		return view('admin.dashboard');
	})->name('admin.dashboard');

	Route::resource('companies', CompanyController::class);
	Route::resource('projects',  ProjectController::class);
	Route::resource('tasks', 	 TaskController::class);
	Route::resource('roles',  	 RoleController::class);
	Route::resource('users', 	 UserController::class);
	
	////////////////////////////////////////////////////////////////////////////////////////////////

	Route::get('companiesList', [CompanyController::class, 'getCompanies'])->name('companies.list');
	Route::get('projectList', 	[ProjectController::class, 'getProjects'])->name('projects.list');
	Route::get('TaskList', 		[TaskController::class,    'getTasks'])->name('tasks.list');
	Route::get('rolesList', 	[RoleController::class,    'getRoles'])->name('roles.list');
	Route::get('usersList', 	[UserController::class,    'getUsers'])->name('users.list');

	////////////////////////////////////////////////////////////////////////////////////////////////                               


});