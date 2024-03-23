<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AccessControlController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/register', [HomeController::class, 'index'])->name('register');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/', [HomeController::class, 'index'])->middleware(['auth']);

      //Logged User Profile
      Route::controller(ProfileController::class)->name('profile.')->prefix('profile')->group(function () {
          Route::get('',  'index')->name('index');
          Route::post('changeStatus', 'changeStatus')->name('changeStatus');
      });

    //Logged User Settings
    Route::controller(SettingsController::class)->name('settings.')->prefix('settings')->group(function () {
        Route::get('','index')->name('index');
        Route::post('/changePassword', 'changePassword')->name('changePassword');
    });

    //Logged Tenants
    Route::controller(App\Http\Controllers\TenantsController::class)->name('tenants.')->prefix('tenants')->group(function () {
        Route::get('',  'index')->name('index')->middleware(['role:Managers|Admin']);
        Route::get('create/{tenant?}', 'edit')->name('edit')->middleware(['role:Managers|Admin']);
        Route::get('tokens/{tenant?}', 'tokens')->name('tokens')->middleware(['role:Managers|Admin']);
        Route::post('store/{tenant?}',  'store')->name('store')->middleware(['role:Managers|Admin']);
        Route::post('destroy/{tenant?}',  'destroy')->name('destroy')->middleware(['role:Managers|Admin']);
    });

    Route::controller(UsersController::class)->name('users.')->prefix('users')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create')->middleware(['role:Admin|Managers|Editors']);
        Route::get('/edit/{user}','create')->name('edit')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::post('/store/{user?}', 'store')->name('store')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::get('/details/{id}', 'view')->name('details')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors|Viewer']);
        Route::post('/changePassword/{user}', 'changePassword')->name('change_password')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::get('/showEditPassword/{id}', 'showEditPassword')->name('showEditPassword')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::post('/editPassword', 'editPassword')->name('editPassword')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::post('changeStatus/{user}', 'changeStatus')->name('changeStatus')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
    });

    Route::controller(GroupController::class)->name('groups.')->prefix('groups')->group(function () {
        Route::get('', 'index')->name('index')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);;
        Route::get('/create/{group?}', 'create')->name('create')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::post('/store/{group?}','store')->name('store')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::get('/edit/{group?}','create')->name('edit')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
        Route::post('/destroy', 'destroy')->name('destroy')->middleware(['role:Admin|Reservationist|Admin|Managers|Editors']);
    });


    Route::controller(AccessControlController::class)->name('access-control.')->prefix('access-control')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('get-users-and-groups', 'getUsersAndGroups')->name('get-users-and-groups');
            Route::post('', 'store')->name('store');
    });



    //preparing To-Do and To-Do actions on one Controller
    Route::controller(ToDoController::class)->name('todos.')->prefix('todos')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/details/{todo?}', 'details')->name('details');
        Route::get('create/', 'create_edit')->name('create');
        Route::get('edit/{todo?}', 'create_edit')->name('edit');
        Route::post('store/{todo?}',  'store')->name('store');
        Route::post('/storeAssignedUser','storeAssignedUser')->name('storeAssignedUser');
        Route::post('changeStatus','changeStatus')->name('changeStatus');

    });


});



