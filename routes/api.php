<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['XSS']], function () {
    Route::get('test-sql-injection', [ApiController::class, 'testSqlInjection']);

});


Route::get('webhock', [ApiController::class, 'webhock']);



Route::get('get-all-beneficiary', [ApiController::class, 'getAllBeneficiary']);
Route::get('add-beneficiary', [ApiController::class, 'addBeneficiary']);
Route::get('get-special-beneficiary-record', [ApiController::class, 'GetSpecialBeneficiaryRecord']);
Route::get('delete-beneficiary', [ApiController::class, 'deleteBeneficiary']);
Route::get('account-verification', [ApiController::class, 'accountVerification']);
Route::get('money-transfer', [ApiController::class, 'moneyTransfer']);


