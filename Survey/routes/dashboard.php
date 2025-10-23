<?php

use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\Groups\GroupController;
use App\Http\Controllers\Dashboard\Question\QuestionController;
use App\Http\Controllers\Dashboard\Role\RoleController;
use App\Http\Controllers\Dashboard\Step\StepController;
use App\Http\Controllers\Dashboard\Survey\BuildingController;
use App\Http\Controllers\Dashboard\Survey\GeneralController;
use App\Http\Controllers\Dashboard\Survey\SafeSecurityController;
use App\Http\Controllers\Dashboard\Survey\SurveyController;
use App\Http\Controllers\Dashboard\User\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::get('dashboard/login', [LoginController::class,'login'])->name('dashboard.login');
Route::post('dashboard/login', [LoginController::class,'loginProcess'])->name('dashboard.loginProcess');
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.','middleware' => ['auth:users', 'activeUser:users']],function(){

        Route::post('/logout', [\App\Http\Controllers\Dashboard\Auth\LogoutController::class,'logout'])->name('logout');
        Route::get('/index',[\App\Http\Controllers\Dashboard\HomeController::class, 'index'])->name('index');

     /*
      * --------------------------------------------
      * | User Routes
      * --------------------------------------------
      */
        Route::resource('users',UserController::class)->only(['index','store','update']);

      /*
       * --------------------------------------------
       * | Roles Routes
       * --------------------------------------------
       */
        Route::resource('roles',RoleController::class);

       /*
        * --------------------------------------------
        * | Steps Routes
        * --------------------------------------------
        */
        Route::resource('steps',StepController::class)->only(['index','store','update']);

        /*
         *--------------------------------------------
         *| Groups Routes
         *--------------------------------------------
         */
        Route::resource('groups',GroupController::class)->only(['index','store','update']);
        Route::get('groups/step/{step}' ,[GroupController::class, 'groupsStep'])->name('groups.step');

        /*
         * --------------------------------------------
         * | Questions Routes
         * --------------------------------------------
         */
        Route::resource('questions',QuestionController::class)->only(['index','store','update']);


        /*
         * --------------------------------------------
         * | Survey Safe & Security Routes
         * --------------------------------------------
         */
        Route::get('surveys/index/safe-security',[SafeSecurityController::class,'index'])->name('surveys.safe-security.index');
        Route::get('surveys/create/safe-security',[SafeSecurityController::class,'create'])->name('surveys.safe-security.create');
        Route::post('surveys/store/safe-security',[SafeSecurityController::class,'store'])->name('surveys.safe-security.store');
        Route::get('surveys/{survey}/show/safe-security',[SafeSecurityController::class,'show'])->name('surveys.safe-security.show');
        Route::get('surveys/{survey}/edit/safe-security',[SafeSecurityController::class,'edit'])->name('surveys.safe-security.edit');
        Route::put('surveys/{survey}/update/safe-security',[SafeSecurityController::class,'update'])->name('surveys.safe-security.update');

       /*
        * --------------------------------------------
        * | Survey General Routes
        * --------------------------------------------
        */
        Route::get('surveys/general/index',[GeneralController::class,'index'])->name('surveys.general.index');
        Route::get('surveys/general/create',[GeneralController::class,'create'])->name('surveys.general.create');
        Route::post('surveys/general/store',[GeneralController::class,'store'])->name('surveys.general.store');
        Route::get('surveys/{survey}/general/show',[GeneralController::class,'show'])->name('surveys.general.show');
        Route::get('surveys/{survey}/general/edit',[GeneralController::class,'edit'])->name('surveys.general.edit');
        Route::put('surveys/{survey}/general/update',[GeneralController::class,'update'])->name('surveys.general.update');


      /*
       * --------------------------------------------
       * | Survey Building Routes
       * --------------------------------------------
       */
        Route::get('surveys/building/index',[BuildingController::class,'index'])->name('surveys.building.index');
        Route::get('surveys/building/create',[BuildingController::class,'create'])->name('surveys.building.create');
        Route::post('surveys/building/store',[BuildingController::class,'store'])->name('surveys.building.store');
        Route::get('surveys/{survey}/building/show',[BuildingController::class,'show'])->name('surveys.building.show');
        Route::get('surveys/{survey}/building/edit',[BuildingController::class,'edit'])->name('surveys.building.edit');
        Route::put('surveys/{survey}/building/update',[BuildingController::class,'update'])->name('surveys.building.update');


        Route::get('surveys/index' , [SurveyController::class, 'index'])->name('surveys.index');

        Route::post('surveys/{surveys}/attachment/destroy',[SurveyController::class,'destroyAttachment'])->name('surveys.attachment.destroy');
    });// End Prefix Dashboard

});// End Prefix LocalizationRedirect
