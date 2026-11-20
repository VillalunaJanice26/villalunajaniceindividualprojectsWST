
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserEquipmentsController;
use App\Http\Controllers\Api\V1\EquipmentController;

// Public Equipment Routes
Route::get('/equipments', [
    EquipmentController::class,
    'index'
]);

Route::get('/equipments/{equipment}', [
    EquipmentController::class,
    'show'
]);

// Public Nested User Equipment Route
Route::get('/users/{user}/equipments', [
    UserEquipmentsController::class,
    'index'
]);

// Protected Routes
Route::middleware('auth:api')->group(function () {

    // Regular Equipment Routes
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

    // Nested Equipment Routes
    Route::apiResource('users.equipments', UserEquipmentsController::class)
        ->only(['store', 'destroy'])
        ->scoped();

    Route::put('/users/{user}/equipments/{equipment}', [
        UserEquipmentsController::class,
        'replace'
    ])->scopeBindings();

    Route::patch('/users/{user}/equipments/{equipment}', [
        UserEquipmentsController::class,
        'update'
    ])->scopeBindings();
});
