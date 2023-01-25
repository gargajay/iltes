<?php

use App\Http\Controllers\FeeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestCategoryController;
use App\Models\TestCategory;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'],'prefix' => 'backend'], function()
{

    //roles route


    

    Route::get('/change-password', [UserController::class, 'changePassword']);
    Route::post('/change-password', [UserController::class, 'updatePassword']);


    

    Route::resources([
        'role' => RoleController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::get('role/status/{id}/{status}', [RoleController::class, 'status']);
    Route::post('role/bulk-delete', [RoleController::class, 'bulkDelete']);


     //roles permission

     Route::resources([
        'permission' => PermissionController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::get('permission/status/{id}/{status}', [PermissionController::class, 'status']);
    Route::post('permission/bulk-delete', [PermissionController::class, 'bulkDelete']);

      //Use users


      Route::resources([
        'student' => UserController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::get('student/status/{id}/{status}', [UserController::class, 'status']);
    Route::post('student/bulk-delete', [UserController::class, 'bulkDelete']);
    Route::get('student/profile', [UserController::class, 'myProfile']);

      Route::resources([
        'user' => UserController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::get('user/status/{id}/{status}', [UserController::class, 'status']);
    Route::post('user/bulk-delete', [UserController::class, 'bulkDelete']);
    Route::get('user/profile', [UserController::class, 'myProfile']);





     //Use inqiuery

     

     Route::resources([
        'inquiry' => InquiryController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::post('inquiry/bulk-delete', [InquiryController::class, 'bulkDelete']);
    Route::get('inquiry/status/{id}/{status}', [UserController::class, 'status']);

 // records

    Route::resources([
        'record' => RecordController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::post('record/bulk-delete', [RecordController::class, 'bulkDelete']);
    Route::get('record/status/{id}/{status}', [RecordController::class, 'status']);

   

        // fee


    Route::resources([
        'fee' => FeeController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::post('fee/bulk-delete', [InquiryController::class, 'bulkDelete']);
    Route::get('fee/status/{id}/{status}', [UserController::class, 'status']);


    






    //Use Labs

    Route::resources([
        'lab' => LabController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::get('lab/status/{id}/{status}', [LabController::class, 'status']);
    Route::post('lab/bulk-delete', [LabController::class, 'bulkDelete']);

     //Use test category

     Route::resources([
        'testCategory' => TestCategoryController::class
    ],
    [
        'except' => ['show'],
    ]);
    Route::get('testCategory/status/{id}/{status}', [TestCategoryController::class, 'status']);
    Route::post('testCategory/bulk-delete', [TestCategoryController::class, 'bulkDelete']);    



    

    
   

    
  
});