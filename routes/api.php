<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CandidateController;
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

// Use semantic versioning
Route::prefix('v1.0.0')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('candidate')->middleware(['role:senior-hrd'])->group(function () {
            Route::get('/', [CandidateController::class, 'index']);
            Route::post('/', [CandidateController::class, 'store']);
            Route::get('/{id}', [CandidateController::class, 'show']);
            Route::put('/{id}', [CandidateController::class, 'update']);
            Route::delete('/{id}', [CandidateController::class, 'destroy']);
            Route::post('/upload', [CandidateController::class, 'upload']);
        });

        Route::get('/resume/{file}', [CandidateController::class, 'viewUploadedResume']);
    });
});
