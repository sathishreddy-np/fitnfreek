<?php

use App\Http\Controllers\BookSlotController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('companies.branches', BranchController::class);
    Route::apiResource('companies.branches.slots', SlotController::class);
    Route::apiResource('companies.branches.bookslots', BookSlotController::class);
});

// Autentication
Route::post('login', [LoginController::class, 'login']);
Route::post('generateOtp', [LoginController::class, 'generateOtp']);
