
<?php

use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponses;

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

