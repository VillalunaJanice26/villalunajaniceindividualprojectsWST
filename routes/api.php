
<?php

use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponses;

// Test Success API Response
Route::get('/test-success', function () {
    return (new class {
        use ApiResponses;

        public function test()
        {
            return $this->successResponse(
                [
                    'project' => 'Equipment Maintenance Tracking System'
                ],
                'API Response is working!',
                200
            );
        }
    })->test();
});

// Get All Equipments
Route::get('/equipments', function () {
    return (new class {
        use ApiResponses;

        public function index()
        {
            return $this->successResponse(
                [],
                'Equipment list retrieved successfully',
                200
            );
        }
    })->index();
});

// Get Equipment by ID
Route::get('/equipments/{id}', function ($id) {
    return (new class {
        use ApiResponses;

        public function show($id)
        {
            return $this->successResponse(
                [
                    'id' => $id,
                    'name' => 'Sample Equipment'
                ],
                'Equipment retrieved successfully',
                200
            );
        }
    })->show($id);
});
