<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {

//    $user =  Auth::user();
// //    if ($user->hasRole('Super-Admin') || $user->hasRole('staff')) {
// //    // dd(1);
// //    return view('backend.dashboard');
// //      }
// //     return view('dashboard');

//     return view('backend.dashboard');

// })->middleware(['auth'])->name('dashboard');

Route::get('role/status/{id}/{status}', [RoleController::class, 'status']);





Route::group(['middleware' => ['auth']], function()
{
    Route::get('/', [UserController::class, 'dashboard']);

    //Admin Dashboard
   
    Route::get('/dashboard', [UserController::class, 'dashboard']);

    
  
});

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
