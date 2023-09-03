<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserInvoicesController;
use App\Http\Controllers\Api\PackageUserMetasController;
use App\Http\Controllers\Api\UserInstallationsController;

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

Route::post('/login', [ApiController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [ApiController::class, 'user']);
    Route::get('/district', [ApiController::class, 'district']);
    Route::get('/ward', [ApiController::class, 'ward']);
    Route::post('/installation', [ApiController::class, 'installation']);
    Route::post('/installation/update', [ApiController::class, 'updateInstallation']);
    Route::get('/invoice', [ApiController::class, 'getInvoice']);
});
