
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// Create Equipment
Route::post('/equipments', function (Request $request) {
    return (new class {
        use ApiResponses;

        public function store($request)
        {
            return $this->successResponse(
                $request->all(),
                'Equipment created successfully',
                201
            );
        }
    })->store($request);
});

// Update Equipment
Route::put('/equipments/{id}', function (Request $request, $id) {
    return (new class {
        use ApiResponses;

        public function update($request, $id)
        {
            return $this->successResponse(
                array_merge(
                    ['id' => $id],
                    $request->all()
                ),
                'Equipment updated successfully',
                200
            );
        }
    })->update($request, $id);
});

// Delete Equipment
Route::delete('/equipments/{id}', function ($id) {
    return (new class {
        use ApiResponses;

        public function destroy($id)
        {
            return $this->successResponse(
                [
                    'id' => $id
                ],
                'Equipment deleted successfully',
                200
            );
        }
    })->destroy($id);
});
