<?php

use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponses;

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