
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // 401 Unauthorized
        $exceptions->render(function (
            AuthenticationException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'errors' => [
                        [
                            'status' => 401,
                            'message' => 'Unauthenticated.',
                            'source' => '',
                        ],
                    ],
                ], 401);
            }
        });

        // 404 Not Found
        $exceptions->render(function (
            NotFoundHttpException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {

                $previous = $e->getPrevious();

                $source = $previous instanceof ModelNotFoundException
                    ? $previous->getModel()
                    : 'Route';

                return response()->json([
                    'errors' => [
                        [
                            'status' => 404,
                            'message' => 'Resource not found.',
                            'source' => $source,
                        ],
                    ],
                ], 404);
            }
        });

        // 405 Method Not Allowed
        $exceptions->render(function (
            MethodNotAllowedHttpException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'errors' => [
                        [
                            'status' => 405,
                            'message' => 'Method not allowed.',
                            'source' => 'Route',
                        ],
                    ],
                ], 405);
            }
        });

        // 422 Validation Error
        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {

                $errors = [];

                foreach ($e->errors() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errors[] = [
                            'status' => 422,
                            'message' => $message,
                            'source' => $field,
                        ];
                    }
                }

                return response()->json([
                    'errors' => $errors,
                ], 422);
            }
        });

    })->create();
