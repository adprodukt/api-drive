<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\YearController;
use App\Http\Middleware\AdminCheck;
use App\Models\Year;
use Illuminate\Support\Facades\Route;



Route::post('/authorization', [UserController::class, 'authorization']);


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/years', [YearController::class, 'index']);
    Route::get('/specialties', [SpecialtyController::class, 'index']);

    Route::get('/groups/year/{year_id}', [GroupController::class, 'index_year']);
    Route::get('/groups/speciality/{speciality_id}', [GroupController::class, 'index_speciality']);
    Route::get('/groups/{group_id}/files', [GroupController::class, 'index_files']);

    Route::post('/files', [FileController::class, 'store']);
    Route::delete('/files/{file_id}', [FileController::class, 'destroy']);
    Route::patch('/files/{file_id}', [FileController::class, 'update']);
    Route::get('/files/{file_id}/download', [FileController::class, 'download']);
    Route::get('/files/search', [FileController::class, 'search']);


    Route::middleware(AdminCheck::class)->group(function () {
        Route::post('/registration', [UserController::class, 'store']);

        Route::post('/years', [YearController::class, 'store']);
        Route::delete('/years/{year_id}', [YearController::class, 'destroy']);
        
        Route::post('/specialties', [SpecialtyController::class, 'store']);
        Route::delete('/specialties/{speciality_id}', [SpecialtyController::class, 'destroy']);
        Route::patch('/specialties/{speciality_id}', [SpecialtyController::class, 'update']);
        
        Route::post('/groups', [GroupController::class, 'store']);
        Route::get('/groups', [GroupController::class, 'index']);
        Route::delete('/groups/{group_id}', [GroupController::class, 'destroy']);
        Route::patch('/groups/{group_id}', [GroupController::class, 'update']);
    });
});











