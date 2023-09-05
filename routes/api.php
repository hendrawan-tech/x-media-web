<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [ApiController::class, 'user']);
    Route::get('/district', [ApiController::class, 'district']);
    Route::get('/ward', [ApiController::class, 'ward']);
    Route::post('/installation', [ApiController::class, 'installation']);
    Route::post('/installation/update', [ApiController::class, 'updateInstallation']);
    Route::get('/invoices', [ApiController::class, 'getInvoice']);
    Route::get('/promo', [ApiController::class, 'promo']);
    Route::get('/article', [ApiController::class, 'article']);
    Route::get('/about', [ApiController::class, 'about']);
    Route::post('/invoice/create', [ApiController::class, 'createInvoice']);
    Route::post('/invoice/offline', [ApiController::class, 'paymentOffline']);
    Route::get('/invoice', [ApiController::class, 'getInvoices']);
});
