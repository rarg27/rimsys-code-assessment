<?php

use App\Http\API\Documents\Controllers\DocumentAttachmentController;
use App\Http\API\Documents\Controllers\DocumentController;
use App\Http\API\Users\Controllers\UserController;
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

Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'all']);

    Route::get('/{id}', [UserController::class, 'get']);

    Route::post('/', [UserController::class, 'store']);

    Route::put('/{user}', [UserController::class, 'update']);

    Route::delete('/{user}', [UserController::class, 'delete']);

});

Route::prefix('documents')->group(function () {

    Route::get('/', [DocumentController::class, 'all']);

    Route::get('/{id}', [DocumentController::class, 'get']);

    Route::post('/', [DocumentController::class, 'store']);

    Route::put('/{document}', [DocumentController::class, 'update']);

    Route::delete('/{document}', [DocumentController::class, 'delete']);

    Route::get('/{document}/download', [DocumentController::class, 'download']);

    Route::prefix('/{document}/attachments')->group(function () {

        Route::get('/', [DocumentAttachmentController::class, 'all']);

        Route::post('/', [DocumentAttachmentController::class, 'store']);

        Route::put('/{id}', [DocumentAttachmentController::class, 'update']);

        Route::delete('/{id}', [DocumentAttachmentController::class, 'delete']);

        Route::get('/{id}/download', [DocumentAttachmentController::class, 'download']);

    });

});

