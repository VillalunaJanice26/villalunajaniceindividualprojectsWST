
<?php

use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponses;
use App\Http\Controllers\Api\V1\UserEquipmentsController;
use App\Http\Controllers\Api\V1\EquipmentController;

// V1 - Get All Equipments
Route::get('/equipments', function () {
    return (new class {
        use ApiResponses;

        public function index()
        {
            return $this->successResponse(
                [],
                'V1: Equipment list retrieved successfully',
                200
            );
        }
    })->index();
});

// V1 - Get Equipment by ID
Route::get('/equipments/{id}', function ($id) {
    return (new class {
        use ApiResponses;

        public function show($id)
        {
            return $this->successResponse(
                [
                    'id' => $id,
                    'name' => 'V1 Sample Equipment'
                ],
                'V1: Equipment retrieved successfully',
                200
            );
        }
    })->show($id);
});

// V1 - Create and Delete Equipment
Route::apiResource('equipments', EquipmentController::class)
    ->only(['store', 'destroy']);

// V1 - Replace Equipment (PUT)
Route::put('/equipments/{equipment}', [
    EquipmentController::class,
    'replace'
]);

// V1 - Update Selected Fields (PATCH)
// JWT authentication required
Route::patch('/equipments/{equipment}', [
    EquipmentController::class,
    'update'
])->middleware('auth:api');

// V1 - Get Equipments of One User
Route::apiResource('users.equipments', UserEquipmentsController::class)
    ->only(['index']);
