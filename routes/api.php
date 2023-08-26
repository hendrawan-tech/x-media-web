<?php

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('apps', AppController::class);

        Route::apiResource('invoices', InvoiceController::class);

        Route::apiResource('packages', PackageController::class);

        // Package User Metas
        Route::get('/packages/{package}/user-metas', [
            PackageUserMetasController::class,
            'index',
        ])->name('packages.user-metas.index');
        Route::post('/packages/{package}/user-metas', [
            PackageUserMetasController::class,
            'store',
        ])->name('packages.user-metas.store');

        Route::apiResource('users', UserController::class);

        // User Installations
        Route::get('/users/{user}/installations', [
            UserInstallationsController::class,
            'index',
        ])->name('users.installations.index');
        Route::post('/users/{user}/installations', [
            UserInstallationsController::class,
            'store',
        ])->name('users.installations.store');

        // User Invoices
        Route::get('/users/{user}/invoices', [
            UserInvoicesController::class,
            'index',
        ])->name('users.invoices.index');
        Route::post('/users/{user}/invoices', [
            UserInvoicesController::class,
            'store',
        ])->name('users.invoices.store');
    });
