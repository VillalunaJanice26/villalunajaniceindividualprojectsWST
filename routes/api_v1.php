
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserEquipmentsController;
use App\Http\Controllers\Api\V1\EquipmentController;

// V1 - Get All Equipments
Route::get('/equipments', [
    EquipmentController::class,
    'index'
]);

// V1 - Get Equipment by ID
Route::get('/equipments/{equipment}', [
    EquipmentController::class,
    'show'
]);

// Protected Equipment Routes - JWT Authentication Required
Route::middleware('auth:api')->group(function () {

    Route::apiResource('equipments', EquipmentController::class)
        ->only(['store', 'destroy']);

    Route::put('/equipments/{equipment}', [
        EquipmentController::class,
        'replace'
    ]);

    Route::patch('/equipments/{equipment}', [
        EquipmentController::class,
        'update'
    ]);

});

// V1 - Get Equipments of One User
Route::apiResource('users.equipments', UserEquipmentsController::class)
    ->only(['index']);
